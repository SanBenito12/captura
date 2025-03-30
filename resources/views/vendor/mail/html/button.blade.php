@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])
<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="{{ $align }}">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td align="{{ $align }}">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td>
                                    <a href="{{ $url }}" class="button button-{{ $color }}" target="_blank" rel="noopener" style="
                                    background: linear-gradient(45deg, #8A4FFF, #E66FFF);
                                    border: none;
                                    border-radius: 9999px;
                                    color: white;
                                    display: inline-block;
                                    font-weight: bold;
                                    padding: 12px 24px;
                                    text-decoration: none;
                                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                    transition: all 0.3s ease;
                                ">{{ $slot }}</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
