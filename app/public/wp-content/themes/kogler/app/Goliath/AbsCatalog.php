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
                'group' => 'abs',
                'title' => '3-in-1 ABS Assembly',
                'intro' => 'Air and electrical in one spiral-wrapped assembly. Standard or Full Assembly, in 12 ft and 15 ft.',
                'image_id' => 404,
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
                        'box_image_id' => 406,
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
                        'box_image_id' => 405,
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
                'group' => 'abs',
                'title' => '7-Way Electrical Cable',
                'intro' => 'Heavy-duty trailer power cable with zinc plugs. Straight or coiled, in 12 ft and 15 ft.',
                'image_id' => 407,
                'image_alt' => 'Green Goliath Steel 7-way electrical cable with zinc plugs',
                'detail_image_id' => 409,
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
                        'box_image_id' => 410,
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
                        'box_image_id' => 408,
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
                'group' => 'abs',
                'title' => 'Air Brake Hoses',
                'intro' => 'Straight rubber service and emergency air lines, 15 ft, sold individually.',
                'image_id' => 411,
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
            [
                'id' => 'diamond-grip',
                'group' => 'gloves',
                'title' => 'Diamond-Grip Nitrile Gloves',
                'intro' => 'Heavy-duty orange nitrile with a raised diamond texture for a sure grip on tools and parts.',
                'image_id' => 0,
                'image_alt' => 'Orange nitrile glove with a close-up of the raised diamond texture',
                'box_image_id' => 0,
                'box_alt' => 'Goliath Steel disposable nitrile gloves box',
                'stats' => [
                    ['value' => '8 mil', 'label' => 'Industry-standard thickness'],
                    ['value' => '100', 'label' => 'Gloves per box (90 in XXL)'],
                    ['value' => '10', 'label' => 'Boxes per case'],
                ],
                'cards' => [
                    ['title' => 'Diamond-Grip Texture', 'text' => 'Sure grip on tools and oily parts, and adds durability.'],
                    ['title' => 'Resists Tears', 'text' => '8-mil nitrile stands up to shop work and protects hands.'],
                    ['title' => 'Latex-Free', 'text' => 'No latex allergy concerns for techs or drivers.'],
                    ['title' => 'Bright Orange', 'text' => 'Easy to spot on the bench and easy to tell apart on the shelf.'],
                ],
                'note' => 'Sold by the case. Case = 10 boxes; 100 gloves per box, 90 per box in XXL.',
                'features' => [],
                'variants' => [
                    [
                        'key' => 'orange',
                        'parts' => [
                            self::glove('KOGDGGLOVE-S', 'Orange Diamond-Grip Nitrile Gloves, Small', 'S', '10 × 100'),
                            self::glove('KOGDGGLOVE-M', 'Orange Diamond-Grip Nitrile Gloves, Medium', 'M', '10 × 100'),
                            self::glove('KOGDGGLOVE-L', 'Orange Diamond-Grip Nitrile Gloves, Large', 'L', '10 × 100'),
                            self::glove('KOGDGGLOVE-XL', 'Orange Diamond-Grip Nitrile Gloves, X-Large', 'XL', '10 × 100'),
                            self::glove('KOGDGGLOVE-XXL', 'Orange Diamond-Grip Nitrile Gloves, XX-Large', 'XXL', '10 × 90'),
                        ],
                    ],
                ],
            ],
            [
                'id' => 'black-nitrile',
                'group' => 'gloves',
                'title' => 'Black Nitrile Disposable Gloves',
                'intro' => 'Industrial-grade nitrile shop gloves in black. Sold by the case in Large and X-Large.',
                'features' => [
                    ['feature' => 'Nitrile', 'benefit' => 'Holds up to oil, grease and shop grime'],
                    ['feature' => 'Latex-free', 'benefit' => 'No latex allergy concerns for techs or drivers'],
                    ['feature' => 'Black color', 'benefit' => 'Hides grease and dirt; clean, professional look'],
                    ['feature' => 'Disposable', 'benefit' => 'A fresh pair for every job; no cleanup'],
                    ['feature' => 'Industrial grade', 'benefit' => 'Made for shop and fleet maintenance work'],
                    ['feature' => 'Sold by the case', 'benefit' => 'Easy to stock and reorder'],
                ],
                'variants' => [
                    [
                        'key' => 'black',
                        'parts' => [
                            self::black('KOGGLOVEB-L', 'Black Nitrile Disposable Gloves, Large', 'Large'),
                            self::black('KOGGLOVEB-XL', 'Black Nitrile Disposable Gloves, X-Large', 'X-Large'),
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function byGroup(string $group): array
    {
        return array_values(array_filter(
            self::products(),
            static fn (array $product): bool => ($product['group'] ?? 'abs') === $group
        ));
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
            if (($product['group'] ?? 'abs') !== 'abs') {
                continue;
            }

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

    /**
     * @return array{sku: string, description: string, size: string, case: string}
     */
    private static function glove(string $sku, string $description, string $size, string $case): array
    {
        return [
            'sku' => $sku,
            'description' => $description,
            'size' => $size,
            'case' => $case,
        ];
    }

    /**
     * @return array{sku: string, description: string, size: string, color: string, sold_by: string}
     */
    private static function black(string $sku, string $description, string $size): array
    {
        return [
            'sku' => $sku,
            'description' => $description,
            'size' => $size,
            'color' => 'Black',
            'sold_by' => 'Case',
        ];
    }
}
