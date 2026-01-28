<?php

namespace App\Core;

/**
 * EmailService - Handles email notifications for Operon Cortex
 * Uses Hostinger SMTP: smtp.hostinger.com
 */
class EmailService {
    private $config;
    private $lastError = '';

    public function __construct() {
        $this->config = [
            'host' => 'smtp.hostinger.com',
            'port' => 465,
            'encryption' => 'ssl',
            'username' => 'hello@operonagents.com',
            'password' => '', // Set via environment or config file
            'from_name' => 'Operon Cortex',
            'from_email' => 'hello@operonagents.com'
        ];
    }

    /**
     * Set SMTP password (call this before sending)
     */
    public function setPassword($password) {
        $this->config['password'] = $password;
    }

    /**
     * Send event notification email to client
     */
    public function sendEventNotification($clientEmail, $clientName, $projectName, $event, $locale = 'pt-BR') {
        $subject = $this->getSubject($event['type'], $projectName, $locale);
        $body = $this->renderTemplate($event, $projectName, $clientName, $locale);
        
        return $this->send($clientEmail, $subject, $body);
    }

    /**
     * Get email subject based on event type
     */
    private function getSubject($type, $projectName, $locale) {
        $subjects = [
            'pt-BR' => [
                'MICRO' => "🔔 Nova atualização em {$projectName}",
                'MACRO' => "🎯 Marco importante em {$projectName}",
                'CHECKPOINT' => "✅ Novo checkpoint em {$projectName}",
                'WARNING' => "⚠️ Aviso importante - {$projectName}",
                'DOCUMENT' => "📄 Novo documento disponível - {$projectName}",
                'ARTICLE' => "📰 Nova publicação - {$projectName}",
                'NEXT_ACTION' => "🚀 Ação necessária - {$projectName}"
            ],
            'en-US' => [
                'MICRO' => "🔔 New update on {$projectName}",
                'MACRO' => "🎯 Important milestone on {$projectName}",
                'CHECKPOINT' => "✅ New checkpoint on {$projectName}",
                'WARNING' => "⚠️ Important notice - {$projectName}",
                'DOCUMENT' => "📄 New document available - {$projectName}",
                'ARTICLE' => "📰 New publication - {$projectName}",
                'NEXT_ACTION' => "🚀 Action required - {$projectName}"
            ],
            'es-ES' => [
                'MICRO' => "🔔 Nueva actualización en {$projectName}",
                'MACRO' => "🎯 Hito importante en {$projectName}",
                'CHECKPOINT' => "✅ Nuevo checkpoint en {$projectName}",
                'WARNING' => "⚠️ Aviso importante - {$projectName}",
                'DOCUMENT' => "📄 Nuevo documento disponible - {$projectName}",
                'ARTICLE' => "📰 Nueva publicación - {$projectName}",
                'NEXT_ACTION' => "🚀 Acción requerida - {$projectName}"
            ]
        ];

        $lang = $subjects[$locale] ?? $subjects['pt-BR'];
        return $lang[$type] ?? $lang['MICRO'];
    }

    /**
     * Render HTML email template
     */
    private function renderTemplate($event, $projectName, $clientName, $locale) {
        $texts = $this->getTexts($locale);
        $type = $event['type'];
        $title = htmlspecialchars($event['title']);
        $description = nl2br(htmlspecialchars($event['description'] ?? ''));
        
        // Color schemes based on event type
        $colors = [
            'WARNING' => ['bg' => '#FEF3C7', 'border' => '#F59E0B', 'text' => '#92400E'],
            'DOCUMENT' => ['bg' => '#DBEAFE', 'border' => '#3B82F6', 'text' => '#1E40AF'],
            'ARTICLE' => ['bg' => '#E0E7FF', 'border' => '#6366F1', 'text' => '#3730A3'],
            'MACRO' => ['bg' => '#D1FAE5', 'border' => '#10B981', 'text' => '#065F46'],
            'CHECKPOINT' => ['bg' => '#D1FAE5', 'border' => '#10B981', 'text' => '#065F46'],
            'MICRO' => ['bg' => '#F1F5F9', 'border' => '#0A2F2F', 'text' => '#0A2F2F'],
            'NEXT_ACTION' => ['bg' => '#FEE2E2', 'border' => '#EF4444', 'text' => '#991B1B']
        ];
        
        $color = $colors[$type] ?? $colors['MICRO'];
        
        $html = <<<HTML
<!DOCTYPE html>
<html lang="{$locale}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title}</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #F8FAFC;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" style="width: 100%; max-width: 600px; border-collapse: collapse;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0A2F2F 0%, #1A4A4A 100%); padding: 32px; border-radius: 16px 16px 0 0; text-align: center;">
                            <h1 style="margin: 0; color: #C8D5B9; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">
                                OPERON CORTEX
                            </h1>
                            <p style="margin: 8px 0 0; color: rgba(200, 213, 185, 0.7); font-size: 12px; text-transform: uppercase; letter-spacing: 2px;">
                                {$projectName}
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="background: #FFFFFF; padding: 32px; border-left: 1px solid #E2E8F0; border-right: 1px solid #E2E8F0;">
                            <p style="margin: 0 0 24px; color: #64748B; font-size: 14px;">
                                {$texts['greeting']}, <strong style="color: #0A2F2F;">{$clientName}</strong>!
                            </p>
                            
                            <!-- Event Card -->
                            <div style="background: {$color['bg']}; border-left: 4px solid {$color['border']}; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
                                <h2 style="margin: 0 0 8px; color: {$color['text']}; font-size: 18px; font-weight: 700;">
                                    {$title}
                                </h2>
                                <p style="margin: 0; color: {$color['text']}; font-size: 14px; opacity: 0.9;">
                                    {$description}
                                </p>
                            </div>
                            
                            <!-- CTA Button -->
                            <table role="presentation" style="width: 100%;">
                                <tr>
                                    <td align="center">
                                        <a href="https://operonagents.com/dashboard" 
                                           style="display: inline-block; background: #0A2F2F; color: #FFFFFF; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 700; font-size: 14px;">
                                            {$texts['cta']}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background: #F8FAFC; padding: 24px; border-radius: 0 0 16px 16px; border: 1px solid #E2E8F0; border-top: none; text-align: center;">
                            <p style="margin: 0; color: #94A3B8; font-size: 12px;">
                                {$texts['footer']}
                            </p>
                            <p style="margin: 8px 0 0; color: #CBD5E1; font-size: 11px;">
                                © 2026 Operon Agents · operonagents.com
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;

        return $html;
    }

    /**
     * Get localized texts
     */
    private function getTexts($locale) {
        $texts = [
            'pt-BR' => [
                'greeting' => 'Olá',
                'cta' => 'Ver no Dashboard',
                'footer' => 'Este é um e-mail automático do seu projeto.'
            ],
            'en-US' => [
                'greeting' => 'Hello',
                'cta' => 'View Dashboard',
                'footer' => 'This is an automated email from your project.'
            ],
            'es-ES' => [
                'greeting' => 'Hola',
                'cta' => 'Ver Panel',
                'footer' => 'Este es un correo automático de su proyecto.'
            ]
        ];

        return $texts[$locale] ?? $texts['pt-BR'];
    }

    /**
     * Send email using PHP mail() or SMTP
     */
    private function send($to, $subject, $htmlBody) {
        // For now, use PHP's mail() function
        // In production, integrate PHPMailer for SMTP
        
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'From: ' . $this->config['from_name'] . ' <' . $this->config['from_email'] . '>',
            'Reply-To: ' . $this->config['from_email'],
            'X-Mailer: Operon Cortex'
        ];

        try {
            $result = @mail($to, $subject, $htmlBody, implode("\r\n", $headers));
            if (!$result) {
                $this->lastError = 'Failed to send email via mail()';
                // Log for debugging
                error_log("Email send failed to: {$to} - Subject: {$subject}");
            }
            return $result;
        } catch (\Exception $e) {
            $this->lastError = $e->getMessage();
            error_log("Email exception: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get last error message
     */
    public function getLastError() {
        return $this->lastError;
    }
}
