<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('img/thorlog.png') }}">
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #2d3748;
        }
        ::-webkit-scrollbar-thumb {
            background: #4a5568;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #718096;
        }

        /* Glassmorphism effect */
        .glassmorphism {
            background: rgba(45, 55, 72, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.125);
        }

        /* Typing animation */
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: #4299e1 }
        }

        /* Message animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Sidebar transition */
        .sidebar {
            transition: all 0.3s ease-in-out;
        }

        /* Typing indicator - VERSIÓN CORREGIDA */
        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .typing-indicator .dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: #a0aec0;
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out;
        }

        .typing-indicator .dot:nth-child(1) {
            animation-delay: 0s;
        }

        .typing-indicator .dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator .dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        .typing-indicator .text {
            color: #a0aec0;
            font-size: 0.75rem;
            line-height: 1;
        }

        @keyframes bounce {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-5px); }
        }

        /* Animaciones adicionales */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 to-gray-800 text-white min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
<!-- Sidebar Menu -->
<div id="sidebar" class="sidebar fixed left-0 top-0 h-full w-64 bg-gray-800 shadow-xl transform -translate-x-full z-50">
    <div class="p-4 border-b border-gray-700 flex items-center justify-between">
        <h2 class="text-xl font-bold text-blue-400">Menú</h2>
        <button id="close-sidebar" class="text-gray-400 hover:text-white">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="p-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('home') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-home mr-3 text-blue-400"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-cog mr-3 text-blue-400"></i>
                    <span>Configuración</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <i class="fas fa-history mr-3 text-blue-400"></i>
                    <span>Historial</span>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex items-center w-full p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 text-left">
                        <i class="fas fa-sign-out-alt mr-3 text-red-400"></i>
                        <span>Cerrar sesión</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-700">
        <div class="text-center text-gray-400 text-sm">
            Thor AI Chat v1.0
        </div>
    </div>
</div>

<!-- Overlay for sidebar -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

<!-- Main Content -->
<div class="w-full max-w-xl mx-auto relative">
    <!-- Menu Button -->
    <button id="menu-button" class="absolute left-4 top-4 z-30 p-2 rounded-full bg-gray-800 bg-opacity-70 hover:bg-gray-700 transition-all duration-200 transform hover:scale-110">
        <i class="fas fa-bars text-blue-400"></i>
    </button>

    <!-- Floating Action Button -->
    <button id="scroll-to-bottom" class="fixed right-6 bottom-6 z-30 p-3 bg-blue-600 rounded-full shadow-lg hover:bg-blue-700 transition-all duration-200 transform hover:scale-110 hidden">
        <i class="fas fa-arrow-down text-white"></i>
    </button>

    <!-- Chat Container -->
    <div class="glassmorphism rounded-2xl shadow-2xl overflow-hidden animate__animated animate__fadeIn relative">
        <!-- Chat Header -->
        <div class="bg-gray-800 bg-opacity-50 p-4 flex items-center justify-between border-b border-gray-700 relative">
            <div class="flex items-center space-x-3 ml-8">
                <div class="relative">
                    <img src="{{ asset('img/thorlog.png') }}" alt="Logo Thor AI" class="w-8 h-8 animate-float">
                    <div class="absolute -right-1 -bottom-1 w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-blue-400">Thor AI Chat</h1>
                    <div id="typing-indicator" class="typing-indicator hidden">
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="text">Thor está escribiendo...</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-xs text-gray-400">En línea</span>
            </div>
        </div>

        <!-- Chat Messages Container -->
        <div id="chat-container" class="h-[500px] overflow-y-auto p-4 space-y-4 bg-gradient-to-b from-gray-900/50 to-gray-800/50">
            <div id="messages-container" class="space-y-4"></div>
        </div>

        <!-- Message Input Area -->
        <div class="p-4 bg-gray-800 bg-opacity-50 border-t border-gray-700">
            <div class="flex items-end space-x-2">
                <button id="attach-button" class="px-3 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-paperclip text-gray-300"></i>
                </button>
                <textarea
                    id="message-input"
                    placeholder="Escribe un mensaje..."
                    class="flex-1 p-3 bg-gray-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none transition-all duration-300 ease-in-out"
                    rows="1"
                ></textarea>
                <button
                    id="send-message-btn"
                    class="px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                >
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <div class="mt-2 flex justify-between items-center text-xs text-gray-400">
                <div>
                    <button class="hover:text-blue-400 transition-colors duration-200 mr-2">
                        <i class="fas fa-microphone"></i> Voz
                    </button>
                    <button class="hover:text-blue-400 transition-colors duration-200">
                        <i class="fas fa-magic"></i> Sugerencias
                    </button>
                </div>
                <div id="char-counter" class="text-gray-500">0/1000</div>
            </div>
        </div>
    </div>
</div>

<!-- Confetti Effect Container -->
<div id="confetti-container" class="fixed inset-0 pointer-events-none z-50 hidden"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contenedorMensajes = document.getElementById('messages-container');
        const entradaMensaje = document.getElementById('message-input');
        const botonEnviar = document.getElementById('send-message-btn');
        const chatContainer = document.getElementById('chat-container');
        const menuButton = document.getElementById('menu-button');
        const sidebar = document.getElementById('sidebar');
        const closeSidebar = document.getElementById('close-sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const scrollToBottomBtn = document.getElementById('scroll-to-bottom');
        const typingIndicator = document.getElementById('typing-indicator');
        const charCounter = document.getElementById('char-counter');
        const attachButton = document.getElementById('attach-button');
        const confettiContainer = document.getElementById('confetti-container');

        // Sidebar toggle
        menuButton.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        });

        // Scroll to bottom button
        chatContainer.addEventListener('scroll', () => {
            const { scrollTop, scrollHeight, clientHeight } = chatContainer;
            const isNearBottom = scrollHeight - (scrollTop + clientHeight) > 100;

            if (isNearBottom) {
                scrollToBottomBtn.classList.remove('hidden');
            } else {
                scrollToBottomBtn.classList.add('hidden');
            }
        });

        scrollToBottomBtn.addEventListener('click', () => {
            chatContainer.scrollTo({
                top: chatContainer.scrollHeight,
                behavior: 'smooth'
            });
        });

        // Character counter
        entradaMensaje.addEventListener('input', () => {
            const count = entradaMensaje.value.length;
            charCounter.textContent = `${count}/1000`;

            if (count > 900) {
                charCounter.classList.add('text-yellow-400');
                charCounter.classList.remove('text-gray-500');
            } else {
                charCounter.classList.remove('text-yellow-400');
                charCounter.classList.add('text-gray-500');
            }

            if (count > 1000) {
                charCounter.classList.add('text-red-400');
            } else {
                charCounter.classList.remove('text-red-400');
            }
        });

        function agregarMensaje(remitente, mensaje) {
            const contenedorMensaje = document.createElement('div');
            contenedorMensaje.classList.add(
                'transform',
                'transition-all',
                'duration-300',
                'ease-out',
                'animate-slide-in',
                'opacity-0'
            );

            // Estilos condicionales para diferentes tipos de mensajes
            switch(remitente) {
                case 'usuario':
                    contenedorMensaje.classList.add(
                        'ml-auto',
                        'bg-blue-600',
                        'bg-opacity-80',
                        'rounded-xl',
                        'rounded-br-none',
                        'p-3',
                        'max-w-[80%]',
                        'shadow-lg',
                        'hover:scale-[1.02]',
                        'transition-transform'
                    );
                    break;
                case 'ai':
                    contenedorMensaje.classList.add(
                        'mr-auto',
                        'bg-gray-700',
                        'bg-opacity-80',
                        'rounded-xl',
                        'rounded-bl-none',
                        'p-3',
                        'max-w-[80%]',
                        'shadow-lg',
                        'hover:scale-[1.02]',
                        'transition-transform'
                    );
                    break;
                case 'error':
                    contenedorMensaje.classList.add(
                        'mx-auto',
                        'bg-red-600',
                        'bg-opacity-80',
                        'rounded-xl',
                        'p-3',
                        'text-center',
                        'max-w-[90%]',
                        'shadow-lg',
                        'animate-pulse'
                    );
                    break;
                case 'system':
                    contenedorMensaje.classList.add(
                        'mx-auto',
                        'bg-purple-600',
                        'bg-opacity-80',
                        'rounded-xl',
                        'p-3',
                        'text-center',
                        'max-w-[90%]',
                        'shadow-lg'
                    );
                    break;
            }

            const contenidoFormateado = formatearTexto(mensaje);
            contenedorMensaje.innerHTML = contenidoFormateado;

            contenedorMensajes.appendChild(contenedorMensaje);

            // Animación de entrada
            setTimeout(() => {
                contenedorMensaje.classList.remove('opacity-0');
            }, 50);

            // Scroll automático
            setTimeout(() => {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }, 100);
        }

        function formatearTexto(texto) {
            // Formateo avanzado de texto
            texto = texto.replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-blue-300">$1</strong>');
            texto = texto.replace(/(\*|_)(.*?)\1/g, '<em class="italic text-gray-300">$2</em>');
            texto = texto.replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank" class="text-blue-400 underline hover:text-blue-300">$1</a>');

            // Listas
            texto = texto.replace(/(\d+)\.\s+(.*)/g, '<li class="list-decimal ml-4">$2</li>');
            texto = texto.replace(/(<li>.*<\/li>)/g, '<ol class="pl-5">$1</ol>');
            texto = texto.replace(/[-*]\s+(.*)/g, '<li class="list-disc ml-4">$1</li>');
            texto = texto.replace(/(<li>.*<\/li>)/g, '<ul class="pl-5">$1</ul>');

            // Bloques de código
            texto = texto.replace(/```([\s\S]*?)```/g, function (_, codeBlock) {
                return `
                        <div class="relative">
                            <pre class="bg-gray-800 p-3 rounded-md overflow-x-auto text-sm">
                                <code class="text-gray-200">${escapeHtml(codeBlock)}</code>
                            </pre>
                            <button class="copy-button absolute top-2 right-2 px-2 py-1 bg-gray-700 hover:bg-gray-600 rounded-md text-xs font-medium transition-colors duration-200">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    `;
            });

            return texto;
        }

        function escapeHtml(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function copiarAlPortapapeles(button) {
            const codigo = button.parentElement.querySelector('code').innerText;
            navigator.clipboard.writeText(codigo).then(() => {
                button.innerHTML = '<i class="fas fa-check"></i>';
                button.classList.add('bg-green-600', 'hover:bg-green-700');
                setTimeout(() => {
                    button.innerHTML = '<i class="fas fa-copy"></i>';
                    button.classList.remove('bg-green-600', 'hover:bg-green-700');
                }, 2000);
            }).catch(err => {
                console.error('Error al copiar al portapapeles:', err);
            });
        }

        function mostrarTypingIndicator() {
            typingIndicator.classList.remove('hidden');
        }

        function ocultarTypingIndicator() {
            typingIndicator.classList.add('hidden');
        }
        // Validaciones de thor
        let isAIResponding = false;

        // Agregar el tiempo de thor para que responda en el chat
        function enviarMensaje() {
            if (isAIResponding) {
                agregarMensaje('system', '⌛ Espera a que Thor termine de responder...');
                return;
            }

            const mensaje = entradaMensaje.value.trim();
            if (!mensaje) return;

            // Deshabilitar UI
            toggleInputs(false);

            // Procesar mensaje
            agregarMensaje('usuario', mensaje);
            entradaMensaje.value = '';
            entradaMensaje.style.height = 'auto';
            charCounter.textContent = '0/1000';
            charCounter.classList.remove('text-yellow-400', 'text-red-400');
            mostrarTypingIndicator();

            setTimeout(() => {
                fetch('/thor/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ prompt: mensaje })
                })
                    .then(response => response.json())
                    .then(data => {
                        ocultarTypingIndicator();
                        toggleInputs(true); // Habilitar UI

                        if (data.response) {
                            agregarMensaje('ai', data.response);
                            if (/felicidades|éxito|bien hecho|woohoo/i.test(data.response)) {
                                mostrarConfetti();
                            }
                        } else if (data.error) {
                            agregarMensaje('error', data.error);
                        }
                    })
                    .catch(error => {
                        ocultarTypingIndicator();
                        toggleInputs(true);
                        agregarMensaje('error', 'Error de conexión con Thor');
                    });
            }, 1000);
        }

            // Validaciones extras de thoor pensando
        function toggleInputs(enable) {
            isAIResponding = !enable;
            entradaMensaje.disabled = !enable;
            botonEnviar.disabled = !enable;

            if (enable) {
                botonEnviar.classList.add('bg-blue-600', 'hover:bg-blue-700');
                botonEnviar.classList.remove('bg-gray-500', 'cursor-not-allowed');
                entradaMensaje.placeholder = 'Escribe un mensaje...';
            } else {
                botonEnviar.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                botonEnviar.classList.add('bg-gray-500', 'cursor-not-allowed');
                entradaMensaje.placeholder = 'Thor está pensando...';
            }
        }


        function mostrarConfetti() {
            confettiContainer.classList.remove('hidden');

            //confeti con emojis prueba
            const emojis = ['✨', '🌟', '🎉', '🔥', '💎', '🚀', '🌈'];
            const confettiCount = 50;

            for (let i = 0; i < confettiCount; i++) {
                const confetti = document.createElement('div');
                confetti.innerHTML = emojis[Math.floor(Math.random() * emojis.length)];
                confetti.style.position = 'absolute';
                confetti.style.fontSize = `${Math.random() * 20 + 10}px`;
                confetti.style.left = `${Math.random() * 100}vw`;
                confetti.style.top = '-50px';
                confetti.style.opacity = '0';
                confetti.style.transform = `rotate(${Math.random() * 360}deg)`;
                confetti.style.animation = `fall ${Math.random() * 3 + 2}s linear forwards`;

                // Animación personalizada para cada confeti
                const keyframes = `
                        @keyframes fall {
                            0% {
                                transform: translateY(0) rotate(0deg);
                                opacity: 1;
                            }
                            100% {
                                transform: translateY(100vh) rotate(${Math.random() * 360}deg);
                                opacity: 0;
                            }
                        }
                    `;

                const style = document.createElement('style');
                style.innerHTML = keyframes;
                document.head.appendChild(style);

                confettiContainer.appendChild(confetti);

                // Mostrar confeti con delay aleatorio
                setTimeout(() => {
                    confetti.style.opacity = '1';
                }, Math.random() * 1000);

                // Eliminar confeti después de la animación
                setTimeout(() => {
                    confetti.remove();
                    style.remove();
                }, 5000);
            }

            setTimeout(() => {
                confettiContainer.classList.add('hidden');
                confettiContainer.innerHTML = '';
            }, 3000);
        }

        // Event Listeners
        botonEnviar.addEventListener('click', enviarMensaje);

        entradaMensaje.addEventListener('keypress', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                enviarMensaje();
            }
        });

        // Auto-resize textarea
        entradaMensaje.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Delegación de eventos para botones de copiar
        contenedorMensajes.addEventListener('click', function(e) {
            if (e.target.classList.contains('copy-button') ||
                e.target.closest('.copy-button')) {
                const button = e.target.classList.contains('copy-button') ?
                    e.target : e.target.closest('.copy-button');
                copiarAlPortapapeles(button);
            }
        });

        // Attach button
        attachButton.addEventListener('click', function() {
            agregarMensaje('system', 'Función de adjuntar archivos no implementada aún. Próximamente...');
        });

        // Mensaje de bienvenida personalizado
        setTimeout(() => {
            const welcomeMsg = document.createElement('div');
            welcomeMsg.classList.add(
                'mr-auto',
                'bg-gray-700',
                'bg-opacity-80',
                'rounded-xl',
                'rounded-bl-none',
                'p-3',
                'max-w-[80%]',
                'shadow-lg',
                'welcome-message',
                'animate-slide-in'
            );
            welcomeMsg.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <div>
                            <p class="font-bold text-blue-300">¡Hola, Soy Thor!</p>
                            <p class="text-sm text-gray-300">¿En qué puedo ayudarte hoy? 😊</p>
                        </div>
                    </div>
                `;
            contenedorMensajes.appendChild(welcomeMsg);
        }, 1000);
    });
</script>
</body>
</html>
