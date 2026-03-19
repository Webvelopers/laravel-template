<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Session\Store;

final readonly class HumanVerificationChallenge
{
    private const SESSION_KEY = 'registration_human_verification';

    public function __construct(private Store $session) {}

    public function image(): string
    {
        $challenge = $this->challenge();

        if ($challenge === null) {
            $challenge = $this->generate();
            $this->session->put(self::SESSION_KEY, $challenge);
        }

        return 'data:image/svg+xml;base64,'.base64_encode($challenge['svg']);
    }

    public function verify(?string $answer): bool
    {
        $challenge = $this->challenge();

        if ($challenge === null) {
            return false;
        }

        return hash_equals($challenge['answer'], trim((string) $answer));
    }

    public function refresh(): void
    {
        $this->session->put(self::SESSION_KEY, $this->generate());
    }

    public function clear(): void
    {
        $this->session->forget(self::SESSION_KEY);
    }

    /**
     * @return array{svg: string, answer: string}|null
     */
    private function challenge(): ?array
    {
        $challenge = $this->session->get(self::SESSION_KEY);

        if (! is_array($challenge)
            || ! is_string($challenge['svg'] ?? null)
            || ! is_string($challenge['answer'] ?? null)) {
            return null;
        }

        return [
            'svg' => $challenge['svg'],
            'answer' => $challenge['answer'],
        ];
    }

    /**
     * @return array{svg: string, answer: string}
     */
    private function generate(): array
    {
        $characters = collect(range('A', 'Z'))
            ->shuffle()
            ->take(5)
            ->implode('');

        $noisePalette = ['#94a3b8', '#cbd5e1', '#64748b'];
        $glyphPalette = ['#0f172a', '#1e293b', '#334155'];

        $noise = collect(range(1, 7))
            ->map(fn (): string => sprintf(
                '<line x1="%d" y1="%d" x2="%d" y2="%d" stroke="%s" stroke-width="1.5" opacity="0.35" />',
                random_int(0, 220),
                random_int(0, 80),
                random_int(0, 220),
                random_int(0, 80),
                $noisePalette[array_rand($noisePalette)]
            ))
            ->implode('');

        $glyphs = collect(mb_str_split($characters))
            ->map(fn (string $character, int $index): string => sprintf(
                '<text x="%d" y="%d" fill="%s" font-size="30" font-family="monospace" font-weight="700" transform="rotate(%d %d %d)">%s</text>',
                22 + ($index * 36),
                random_int(42, 58),
                $glyphPalette[array_rand($glyphPalette)],
                random_int(-18, 18),
                22 + ($index * 36),
                40,
                $character
            ))
            ->implode('');

        $svg = sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" width="220" height="80" viewBox="0 0 220 80" role="img" aria-label="Human verification image"><rect width="220" height="80" rx="16" fill="#f8fafc" />%s%s</svg>',
            $noise,
            $glyphs,
        );

        return [
            'svg' => $svg,
            'answer' => $characters,
        ];
    }
}
