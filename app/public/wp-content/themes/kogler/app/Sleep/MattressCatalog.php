<?php

namespace App\Sleep;

/**
 * Kögler 2027 mattress catalog.
 * Shared by the sleep intro finder, the fitment guide, and the size grid.
 */
class MattressCatalog
{
    /**
     * @return array{trucks: array<string, array<int, array<string, mixed>>>, makeNotes: array<string, string>, parts: array<string, array<int, array{construction: string, cover: string, sku: string}>>}
     */
    public static function catalog(): array
    {
        return [
            'trucks' => self::trucks(),
            'makeNotes' => [
                'Volvo' => 'Replacement reclining mattresses for Volvo sleepers are available on request.',
            ],
            'parts' => self::parts(),
        ];
    }

    /**
     * Part-number rows for one construction, split by cover.
     * Sizes and SKUs come from the same parts list as the finder.
     *
     * @return array{cloth: array<int, array{sku: string, description: string, size: string}>, wipeable: array<int, array{sku: string, description: string, size: string}>}
     */
    public static function partsForCover(string $construction): array
    {
        $rows = ['cloth' => [], 'wipeable' => []];

        foreach (self::parts() as $width => $parts) {
            foreach ($parts as $part) {
                if ($part['construction'] !== $construction) {
                    continue;
                }

                $widthLabel = (string) $width;
                $length = $widthLabel === '29' ? '79' : '80';
                $row = [
                    'sku' => $part['sku'],
                    'description' => $part['construction'] . ', ' . $part['cover'] . ' Cover',
                    'size' => $widthLabel . '" × ' . $length . '" × 7"',
                ];

                if ($part['cover'] === 'Cloth') {
                    $rows['cloth'][] = $row;
                } elseif ($part['cover'] === 'Wipeable') {
                    $rows['wipeable'][] = $row;
                }
            }
        }

        return $rows;
    }

    /**
     * Spec table rows. Width chips come from the parts list.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function specRows(): array
    {
        $chips = [];

        foreach (array_keys(self::parts()) as $width) {
            $chips[] = $width . '"';
        }

        return [
            ['type' => 'chips', 'label' => 'Widths', 'chips' => $chips],
            ['type' => 'length', 'label' => 'Length', 'value' => '80"', 'note' => '(29" width: 79")'],
            ['type' => 'text', 'label' => 'Thickness', 'value' => '7"'],
            ['type' => 'text', 'label' => 'Construction', 'value' => 'Innerspring or gel-infused foam'],
            ['type' => 'text', 'label' => 'Cover', 'value' => 'Cloth or wipeable nylon'],
        ];
    }

    /**
     * @return array<string, array<int, array<string, mixed>>>
     */
    private static function trucks(): array
    {
        return [
            'Freightliner' => [
                self::model('Cascadia 72" raised roof', [
                    self::bunk('Lower bunk', ['36', '42'], 'Varies by spec'),
                ]),
            ],
            'Kenworth' => [
                self::model('T680', [
                    self::bunk('Lower bunk', ['38/39', '42'], '42" common on 76" sleeper'),
                ]),
                self::model('W900', [
                    self::bunk('Lower bunk', ['42']),
                ]),
            ],
            'Peterbilt' => [
                self::model('579 (80" UltraLoft)', [
                    self::bunk('Lower bunk', ['42'], 'OEM bunk 42" × 85". Width matches; OEM bunk is longer than 80".'),
                    self::bunk('Upper bunk', ['36'], 'OEM bunk 36" × 82". Width matches; OEM bunk is longer than 80".'),
                ]),
                self::model('389 high roof', [
                    self::bunk('Lower bunk', ['42']),
                ]),
            ],
            'Volvo' => [
                self::model('VNL 860', [
                    self::bunk('Lower bunk', ['42']),
                    self::bunk('Upper bunk', ['36'], 'Fixed upper bunk'),
                ]),
                self::model('VNL 740 / 760', [
                    self::bunk('Lower bunk', ['38/39'], 'OEM bunk 39" × 80–81"'),
                ]),
            ],
            'International' => [
                self::model('LT 56"', [
                    self::bunk('Single bunk', ['36']),
                ]),
                self::model('LT 73"', [
                    self::bunk('Lower bunk', ['42']),
                    self::bunk('Upper bunk', ['32'], 'OEM bunk 33.2" wide. Nearest fit; about 1" narrower than the OEM bunk.'),
                ]),
            ],
            'Mack' => [
                self::model('Anthem 70" stand-up', [
                    self::bunk('Lower bunk', ['42']),
                    self::bunk('Upper bunk', ['36']),
                ]),
            ],
            'Western Star' => [
                self::model('5700XE', [
                    self::bunk('Lower bunk', ['42']),
                ]),
            ],
        ];
    }

    /**
     * @return array<string, array<int, array{construction: string, cover: string, sku: string}>>
     */
    private static function parts(): array
    {
        return [
            '28' => [
                self::part('Gel Foam', 'Cloth', 'KOGTR28807G'),
            ],
            '29' => [
                self::part('Innerspring', 'Cloth', 'KOGIS29797E'),
            ],
            '32' => [
                self::part('Innerspring', 'Cloth', 'KOGIS32807E'),
                self::part('Gel Foam', 'Cloth', 'KOGTR32807G'),
                self::part('Gel Foam', 'Wipeable', 'KOGTRA32807E'),
            ],
            '36' => [
                self::part('Innerspring', 'Cloth', 'KOGIS36807E'),
                self::part('Innerspring', 'Wipeable', 'KOGISA36807E'),
                self::part('Gel Foam', 'Cloth', 'KOGTR36807G'),
                self::part('Gel Foam', 'Wipeable', 'KOGTRA36807E'),
            ],
            '38' => [
                self::part('Gel Foam', 'Cloth', 'KOGTR38807G'),
                self::part('Gel Foam', 'Wipeable', 'KOGTRA38807E'),
            ],
            '39' => [
                self::part('Innerspring', 'Cloth', 'KOGIS39807E'),
                self::part('Innerspring', 'Wipeable', 'KOGISA39807E'),
            ],
            '42' => [
                self::part('Innerspring', 'Cloth', 'KOGIS42807E'),
                self::part('Innerspring', 'Wipeable', 'KOGISA42807E'),
                self::part('Gel Foam', 'Cloth', 'KOGTR42807G'),
                self::part('Gel Foam', 'Wipeable', 'KOGTRA42807E'),
            ],
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $bunks
     * @return array{name: string, bunks: array<int, array<string, mixed>>}
     */
    private static function model(string $name, array $bunks): array
    {
        return ['name' => $name, 'bunks' => $bunks];
    }

    /**
     * @param  array<int, string>  $widths
     * @return array{position: string, widths: array<int, string>, note: string}
     */
    private static function bunk(string $position, array $widths, string $note = ''): array
    {
        return ['position' => $position, 'widths' => $widths, 'note' => $note];
    }

    /**
     * @return array{construction: string, cover: string, sku: string}
     */
    private static function part(string $construction, string $cover, string $sku): array
    {
        return ['construction' => $construction, 'cover' => $cover, 'sku' => $sku];
    }
}
