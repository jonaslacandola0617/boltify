<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::query()->pluck('id', 'name');

        $products = [
            ['Power Tools', '12V Cordless Drill Driver', 'Compact two-speed drill driver with keyless chuck, LED work light, and a balanced grip for everyday drilling and fastening.', 2499.00, 18],
            ['Power Tools', '20V Brushless Impact Driver', 'High-torque brushless impact driver built for long screws, lag bolts, cabinetry, and repetitive fastening work.', 4299.00, 9],
            ['Power Tools', '4-inch Angle Grinder 850W', 'Slim-body angle grinder with side handle and spindle lock for cutting, grinding, and surface preparation.', 1899.00, 14],
            ['Power Tools', '13mm Variable-Speed Hammer Drill', 'Corded hammer drill with reversible variable speed for masonry, wood, and metal applications.', 2199.00, 6],
            ['Power Tools', '7-1/4-inch Circular Saw 1400W', 'Jobsite circular saw with adjustable bevel and cutting depth for lumber, sheet goods, and general construction.', 3699.00, 4],

            ['Hand Tools', '16oz Claw Hammer', 'Balanced forged-steel claw hammer with a shock-reducing grip for framing, repair, and general household work.', 349.00, 32],
            ['Hand Tools', '8-inch Combination Pliers', 'Drop-forged combination pliers with serrated jaws and insulated comfort grips for gripping, bending, and cutting.', 329.00, 24],
            ['Hand Tools', '10-inch Adjustable Wrench', 'Chrome-plated adjustable wrench with a wide jaw opening and clear size markings for plumbing and mechanical work.', 449.00, 17],
            ['Hand Tools', '6-piece Screwdriver Set', 'Essential Phillips and slotted screwdriver set with magnetic tips and molded anti-slip handles.', 389.00, 28],
            ['Hand Tools', '5m Auto-Lock Tape Measure', 'Durable five-meter tape with auto-lock blade, belt clip, and high-contrast metric markings.', 199.00, 41],

            ['Fasteners', 'Wood Screws Assorted 200pc', 'Mixed zinc-plated wood screws in practical household and workshop sizes, packed in a reusable organizer.', 289.00, 35],
            ['Fasteners', 'Concrete Nails 2-inch 1kg', 'Hardened steel concrete nails for masonry fastening, rough carpentry, and construction applications.', 179.00, 20],
            ['Fasteners', 'Hex Bolt & Nut Set M8 20pc', 'Zinc-plated M8 hex bolts with matching nuts and washers for fabrication, repair, and fixture installation.', 249.00, 16],

            ['Electrical', 'Heavy-Duty Extension Cord 10m', 'Grounded three-outlet extension cord with durable insulation for workshop tools and general indoor use.', 749.00, 12],
            ['Electrical', 'Electrical Tape 10-pack', 'Flexible PVC insulating tape with reliable adhesion for cable identification, bundling, and electrical repairs.', 199.00, 44],
            ['Electrical', 'Universal Convenience Outlet', 'Surface-mount universal outlet with protective shutter and durable polycarbonate housing.', 159.00, 27],

            ['Plumbing', 'Adjustable Pipe Wrench 14-inch', 'Heavy-duty cast body pipe wrench with hardened serrated jaws for plumbing installation and repair.', 699.00, 11],
            ['Plumbing', 'PTFE Thread Seal Tape 10-pack', 'High-density thread seal tape for water line fittings, valves, faucets, and general plumbing connections.', 129.00, 48],
            ['Plumbing', 'PVC Ball Valve 1/2-inch', 'Compact full-port PVC ball valve for household water lines, irrigation, and utility installations.', 119.00, 22],

            ['Paint & Finishing', 'Premium Interior Latex Paint 4L', 'Low-odor water-based interior paint with smooth coverage and a washable matte finish for walls and ceilings.', 899.00, 10],
            ['Paint & Finishing', 'Clear Wood Varnish 1L', 'Clear protective varnish that enhances wood grain while adding a durable gloss finish for furniture and trim.', 469.00, 13],
            ['Paint & Finishing', 'Paint Roller Set 9-inch', 'Complete roller kit with tray, frame, roller cover, and brush for walls, ceilings, and general repainting.', 299.00, 26],

            ['Building Materials', 'Portland Cement 40kg', 'General-purpose Portland cement for masonry, concrete repair, patching, and small construction projects.', 285.00, 50],
            ['Building Materials', 'Marine Plywood 1/2-inch 4x8', 'Moisture-resistant plywood panel for cabinetry, partitions, furniture, and protected construction applications.', 1095.00, 7],
            ['Building Materials', 'Tie Wire #16 25kg', 'Annealed steel tie wire for reinforcing bars, fabrication, fencing, and general construction fastening.', 1599.00, 3],

            ['Safety & PPE', 'Vented Safety Hard Hat', 'Lightweight hard hat with adjustable suspension, ventilation slots, and a secure ratchet fit for jobsite protection.', 299.00, 25],
            ['Safety & PPE', 'Anti-Fog Safety Goggles', 'Wraparound impact-resistant safety goggles with anti-fog lenses and indirect ventilation.', 189.00, 36],
            ['Safety & PPE', 'Nitrile-Coated Work Gloves', 'Breathable knit work gloves with textured nitrile palms for improved grip and abrasion resistance.', 149.00, 40],
            ['Safety & PPE', 'Reusable Dust Mask with Filters', 'Reusable half-face dust mask supplied with replaceable particulate filters for workshop and renovation tasks.', 499.00, 8],

            ['Adhesives & Sealants', 'Construction Adhesive 300ml', 'High-strength cartridge adhesive for wood, concrete, masonry, panels, trim, and common building materials.', 239.00, 19],
            ['Adhesives & Sealants', 'Neutral Cure Silicone Sealant', 'Weather-resistant silicone sealant for glass, aluminum, tiles, sanitary fixtures, and exterior joints.', 189.00, 23],
            ['Adhesives & Sealants', 'Two-Part Epoxy Adhesive 50ml', 'Fast-setting two-part epoxy for strong repairs on metal, wood, ceramics, and rigid plastics.', 219.00, 15],

            ['Hardware & Accessories', 'Utility Knife with 5 Blades', 'Retractable utility knife with metal body, blade lock, and five replacement blades for workshop and packaging use.', 179.00, 34],
            ['Hardware & Accessories', '4-inch Heavy-Duty Door Hinge Pair', 'Ball-bearing steel hinge pair with mounting screws for interior and utility doors.', 269.00, 21],
            ['Hardware & Accessories', '40mm Laminated Padlock', 'Weather-resistant laminated steel padlock with hardened shackle and three keys for general security.', 349.00, 5],
            ['Hardware & Accessories', '12-inch Aluminum Spirit Level', 'Compact aluminum level with high-visibility horizontal, vertical, and 45-degree vials.', 279.00, 0],
        ];

        foreach ($products as [$category, $name, $description, $price, $stock]) {
            Product::query()->updateOrCreate(
                ['name' => $name],
                [
                    'categoryId' => $categoryIds[$category],
                    'description' => $description,
                    'price' => $price,
                    'stock' => $stock,
                    'images' => json_encode([]),
                ],
            );
        }
    }
}
