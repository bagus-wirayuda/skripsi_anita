<?php
/** Future provider adapter. No network transport is enabled in this version. */
interface WhatsAppGateway {
    /** Return a provider message ID after acceptance; throw on rejection. */
    public function send(string $recipient, string $message, string $idempotencyKey): string;
}

final class DeferredWhatsAppGateway implements WhatsAppGateway {
    public function send(string $recipient, string $message, string $idempotencyKey): string {
        throw new LogicException('Pengiriman WhatsApp ditangguhkan. Hubungkan API penyedia terlebih dahulu.');
    }
}
