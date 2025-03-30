<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class GeminiController extends Controller
{
    /**
     * Método index para mostrar la vista inicial.
     */
    public function index()
    {
        // Limpiar el historial de conversación al cargar la página
        Session::forget('gemini_conversation_history');

        // Retornar la vista gemini
        return view('gemini');
    }

    /**
     * Método chat para procesar las solicitudes del usuario y comunicarse con la API de Gemini.
     */
    public function chat(Request $request)
    {
        // Validar la entrada del usuario
        $request->validate([
            'prompt' => 'required|string|max:1000'
        ]);

        // Obtener el historial de conversación de la sesión
        $conversationHistory = Session::get('gemini_conversation_history', []);

        try {
            // Cliente HTTP para realizar solicitudes a la API de Gemini
            $client = new Client();
            $apiKey = config('services.gemini.api_key');

            // Construir el payload para la API de Gemini
            $payload = $this->buildPayload($conversationHistory, $request->input('prompt'));

            // Realizar la solicitud POST a la API de Gemini
            $response = $client->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent", [
                'query' => ['key' => $apiKey],
                'headers' => ['Content-Type' => 'application/json'],
                'json' => $payload
            ]);

            // Procesar la respuesta de la API
            $body = json_decode($response->getBody(), true);

            // Validar que la respuesta tenga la estructura esperada
            if (!isset($body['candidates'][0]['content']['parts'][0]['text'])) {
                return response()->json([
                    'error' => 'Respuesta de la API inválida',
                    'details' => 'La respuesta no contiene el texto esperado'
                ], 500);
            }

            $generatedText = $body['candidates'][0]['content']['parts'][0]['text'];

            // Actualizar el historial de conversación
            $conversationHistory[] = [
                'role' => 'user',
                'content' => $request->input('prompt')
            ];
            $conversationHistory[] = [
                'role' => 'model',
                'content' => $generatedText
            ];

            // Limitar el historial a los últimos 10 mensajes
            $conversationHistory = array_slice($conversationHistory, -10);
            Session::put('gemini_conversation_history', $conversationHistory);

            // Devolver la respuesta generada como JSON
            return response()->json([
                'response' => $generatedText
            ]);

        } catch (\Exception $e) {
            // Manejar errores específicos de la API
            if ($e->getCode() === 401) {
                Log::error('Error de autenticación con la API de Gemini');
                return response()->json([
                    'error' => 'Error de autenticación',
                    'details' => 'Verifica tu clave API'
                ], 401);
            } elseif ($e->getCode() === 429) {
                Log::error('Límite de solicitudes alcanzado');
                return response()->json([
                    'error' => 'Límite de solicitudes alcanzado',
                    'details' => 'Intenta nuevamente más tarde'
                ], 429);
            } else {
                Log::error('Gemini API Error: ', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return response()->json([
                    'error' => 'Error al comunicarse con la API de Gemini',
                    'details' => $e->getMessage()
                ], 500);
            }
        }
    }

    /**
     * Método para limpiar el historial de conversación.
     */
    public function clearHistory()
    {
        // Limpiar el historial de conversación en la sesión
        Session::forget('gemini_conversation_history');
        return response()->json(['status' => 'Historial limpiado']);
    }

    /**
     * Construye el payload para la API de Gemini.
     *
     * @param array $conversationHistory Historial de conversación
     * @param string $userPrompt Mensaje del usuario
     * @return array Payload para la API
     */
    private function buildPayload(array $conversationHistory, string $userPrompt): array
    {
        return [
            'contents' => array_merge(
                array_map(function ($message) {
                    return [
                        'parts' => [
                            ['text' => $message['content']]
                        ],
                        'role' => $message['role']
                    ];
                }, $conversationHistory),
                [
                    [
                        'parts' => [
                            ['text' => $userPrompt]
                        ],
                        'role' => 'user'
                    ]
                ]
            )
        ];
    }
}
