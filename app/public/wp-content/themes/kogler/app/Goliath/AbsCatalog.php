<?php

namespace App\Goliath;

/**
 * Goliath Steel 2027 ABS assemblies catalog.
 * One list of products and part numbers for the product cards and,
 * later, the Quick Reference table.
 */
class AbsCatalog
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function products(): array
    {
        return [
            [
                'id' => 'abs-3-in-1',
                'title' => '3-in-1 ABS Assembly',
                'intro' => 'Air and electrical in one spiral-wrapped assembly. Standard or Full Assembly, in 12 ft and 15 ft.',
                'image_id' => 0,
                'image_alt' => 'Goliath Steel 3-in-1 ABS assembly, spiral wrapped, with colour-coded grip handles',
                'detail_image_id' => 0,
                'detail_alt' => '',
                'detail_captions' => [],
                'tablist_label' => '3-in-1 assembly type',
                'features' => [
                    ['feature' => 'Spiral wrapped', 'benefit' => 'Organized; resists kinks and abrasion'],
                    ['feature' => 'Zinc 7-way plug, spring guard', 'benefit' => 'Protects the cable at the plug · SAE J560'],
                    ['feature' => 'Green ABS jacketing', 'benefit' => 'ABS circuit easy to identify · SAE J2394'],
                    ['feature' => 'Rubber air lines', 'benefit' => 'Durable and flexible · SAE J1402'],
                    ['feature' => 'Color-coded grip handles', 'benefit' => 'Fast coupling; red/blue easy to tell apart'],
                    ['feature' => 'Brass swivel fitting', 'benefit' => 'Tractor end swivels for easier installation'],
                    ['feature' => 'Rated –40°F to 200°F', 'benefit' => 'Year-round performance'],
                ],
                'variants' => [
                    [
                        'key' => 'standard',
                        'label' => 'Standard',
                        'title' => 'Standard Assembly',
                        'box_image_id' => 0,
                        'box_alt' => 'Standard 3-in-1 assembly retail box',
                        'note' => null,
                        'parts' => [
                            self::part('KOGAP312E', '3-in-1 Air & Electrical', '12 ft', 'Poly bag'),
                            self::part('KOGAP312EB', '3-in-1 Air & Electrical', '12 ft', 'Boxed'),
                            self::part('KOGAP315E', '3-in-1 Air & Electrical', '15 ft', 'Poly bag'),
                            self::part('KOGAP315EB', '3-in-1 Air & Electrical', '15 ft', 'Boxed'),
                        ],
                    ],
                    [
                        'key' => 'full',
                        'label' => 'Full Assembly',
                        'title' => 'Full Assembly',
                        'box_image_id' => 0,
                        'box_alt' => 'Full assembly with gladhands, handles and seals',
                        'note' => [
                            'lead' => 'Full Assembly includes:',
                            'text' => '(1) 3-in-1 assembly, (2) aluminum gladhands, (2) aluminum gladhand handles, (4) rubber seals.',
                        ],
                        'parts' => [
                            self::part('KOGAP312FA', '3-in-1 Air & Electrical, Full Assembly', '12 ft', 'Poly bag'),
                            self::part('KOGAP312FAB', '3-in-1 Air & Electrical, Full Assembly', '12 ft', 'Boxed'),
                            self::part('KOGAP315FA', '3-in-1 Air & Electrical, Full Assembly', '15 ft', 'Poly bag'),
                            self::part('KOGAP315FAB', '3-in-1 Air & Electrical, Full Assembly', '15 ft', 'Boxed'),
                        ],
                    ],
                ],
            ],
            [
                'id' => 'seven-way',
                'title' => '7-Way Electrical Cable',
                'intro' => 'Heavy-duty trailer power cable with zinc plugs. Straight or coiled, in 12 ft and 15 ft.',
                'image_id' => 0,
                'image_alt' => 'Green Goliath Steel 7-way electrical cable with zinc plugs',
                'detail_image_id' => 0,
                'detail_alt' => 'Close-ups of the copper core and the zinc 7-way plug',
                'detail_captions' => ['Copper core', 'Zinc plug'],
                'tablist_label' => '7-way cable type',
                'features' => [
                    ['feature' => '100% oxygen-free copper', 'benefit' => 'Strong conductivity; resists corrosion'],
                    ['feature' => 'Zinc 7-way plug, spring guard', 'benefit' => 'Protects the cable at the plug · SAE J560'],
                    ['feature' => 'Green ABS jacketing', 'benefit' => 'ABS circuit easy to identify · SAE J2394'],
                    ['feature' => 'Rated –40°F to 200°F', 'benefit' => 'Year-round performance'],
                    ['feature' => 'Straight or coiled', 'benefit' => 'Fits the tractor and trailer setup'],
                    ['feature' => '12 ft or 15 ft', 'benefit' => 'The right length for the spread'],
                ],
                'variants' => [
                    [
                        'key' => 'straight',
                        'label' => 'Straight',
                        'title' => 'Straight',
                        'box_image_id' => 0,
                        'box_alt' => '7-way straight trailer cord retail box',
                        'note' => 'Boxed packaging available on request.',
                        'parts' => [
                            self::part('KOG7WS12E', '7-Way Electrical Cable, Straight', '12 ft', 'Poly bag'),
                            self::part('KOG7WS15E', '7-Way Electrical Cable, Straight', '15 ft', 'Poly bag'),
                        ],
                    ],
                    [
                        'key' => 'coiled',
                        'label' => 'Coiled',
                        'title' => 'Coiled',
                        'box_image_id' => 0,
                        'box_alt' => '7-way coiled trailer cord retail box',
                        'note' => 'Boxed packaging available on request.',
                        'parts' => [
                            self::part('KOG7WC12E', '7-Way Electrical Cable, Coiled', '12 ft', 'Poly bag'),
                            self::part('KOG7WC15E', '7-Way Electrical Cable, Coiled', '15 ft', 'Poly bag'),
                        ],
                    ],
                ],
            ],
            [
                'id' => 'air-brake-hoses',
                'title' => 'Air Brake Hoses',
                'intro' => 'Straight rubber service and emergency air lines, 15 ft, sold individually.',
                'image_id' => 0,
                'image_alt' => 'Black rubber air brake hose with red and blue grip handles and brass fittings',
                'detail_image_id' => 0,
                'detail_alt' => '',
                'detail_captions' => [],
                'tablist_label' => '',
                'features' => [
                    ['feature' => 'Rubber jacketing', 'benefit' => 'Durable and flexible · SAE J1402'],
                    ['feature' => 'Color-coded grip handles', 'benefit' => 'Blue for service, red for emergency'],
                    ['feature' => '100% brass swivel fitting', 'benefit' => 'Resists rust; tractor end swivels for easy install'],
                    ['feature' => 'Spring guard', 'benefit' => 'Helps prevent kinks; keeps the fitting secure'],
                    ['feature' => 'Rated –40°F to 120°F', 'benefit' => 'Year-round performance'],
                    ['feature' => 'Sold individually', 'benefit' => 'Replace only the line that needs it'],
                ],
                'variants' => [
                    [
                        'key' => 'straight',
                        'label' => 'Straight',
                        'title' => 'Straight Air Brake Hose',
                        'box_image_id' => 0,
                        'box_alt' => '',
                        'show_box' => false,
                        'note' => 'Boxed packaging available on request.',
                        'parts' => [
                            self::part('KOGALBLU15E', 'Air Brake Hose, Blue (Service)', '15 ft', 'Poly bag'),
                            self::part('KOGALRED15E', 'Air Brake Hose, Red (Emergency)', '15 ft', 'Poly bag'),
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Every SKU, for the Quick Reference table.
     *
     * @return array<int, array<string, string>>
     */
    public static function partRows(): array
    {
        $rows = [];

        foreach (self::products() as $product) {
            foreach ($product['variants'] as $variant) {
                foreach ($variant['parts'] as $part) {
                    $rows[] = $part + [
                        'product_id' => $product['id'],
                        'variant' => $variant['key'],
                    ];
                }
            }
        }

        return $rows;
    }

    /**
     * @return array{sku: string, description: string, length: string, packaging: string}
     */
    private static function part(string $sku, string $description, string $length, string $packaging): array
    {
        return [
            'sku' => $sku,
            'description' => $description,
            'length' => $length,
            'packaging' => $packaging,
        ];
    }
}
