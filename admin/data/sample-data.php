<?php
/**
 * Preview Sample Data Layer
 *
 * All UI sample datasets live in this isolated file so that future MySQLi
 * queries (using config/db.php) can replace these helper functions cleanly
 * without touching the admin templates or mixing hardcoded rows into views.
 */

if (!defined('ADMIN_APP')) {
    exit('Direct access not permitted.');
}

function get_sample_dashboard_stats() {
    return [
        [
            'id'        => 'products',
            'label'     => 'Total Products',
            'value'     => '18',
            'change'    => '+3 added this month',
            'trend'     => 'up',
            'icon'      => 'fas fa-gem',
            'href'      => 'products.php',
        ],
        [
            'id'        => 'orders',
            'label'     => 'Total Orders',
            'value'     => '142',
            'change'    => '+12.4% vs last month',
            'trend'     => 'up',
            'icon'      => 'fas fa-shopping-bag',
            'href'      => 'orders.php',
        ],
        [
            'id'        => 'customers',
            'label'     => 'Total Customers',
            'value'     => '89',
            'change'    => '+9 new collectors',
            'trend'     => 'up',
            'icon'      => 'fas fa-users',
            'href'      => 'customers.php',
        ],
        [
            'id'        => 'revenue',
            'label'     => 'Total Revenue',
            'value'     => '$38,490',
            'change'    => '+18.2% vs last month',
            'trend'     => 'up',
            'icon'      => 'fas fa-dollar-sign',
            'href'      => 'orders.php',
        ],
    ];
}

function get_sample_monthly_sales() {
    return [
        ['month' => 'Dec', 'revenue' => 2450, 'orders' => 9],
        ['month' => 'Jan', 'revenue' => 1980, 'orders' => 7],
        ['month' => 'Feb', 'revenue' => 2890, 'orders' => 11],
        ['month' => 'Mar', 'revenue' => 3120, 'orders' => 12],
        ['month' => 'Apr', 'revenue' => 2740, 'orders' => 10],
        ['month' => 'May', 'revenue' => 3480, 'orders' => 13],
        ['month' => 'Jun', 'revenue' => 3290, 'orders' => 12],
        ['month' => 'Jul', 'revenue' => 3650, 'orders' => 14],
        ['month' => 'Aug', 'revenue' => 3180, 'orders' => 11],
        ['month' => 'Sep', 'revenue' => 3890, 'orders' => 15],
        ['month' => 'Oct', 'revenue' => 4120, 'orders' => 15],
        ['month' => 'Nov', 'revenue' => 4780, 'orders' => 18],
    ];
}

function get_sample_categories() {
    return [
        [
            'id'          => 1,
            'name'        => 'Necklaces',
            'slug'        => 'necklaces',
            'image'       => 'assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg',
            'description' => 'Sculptural 18k gold-plated pendants, layered chains, and statement medallions.',
            'count'       => 6,
            'status'      => 'Active',
        ],
        [
            'id'          => 2,
            'name'        => 'Bracelets',
            'slug'        => 'bracelets',
            'image'       => 'assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg',
            'description' => 'Hand-finished cuffs, delicate bangles, and minimalist everyday wrists.',
            'count'       => 6,
            'status'      => 'Active',
        ],
        [
            'id'          => 3,
            'name'        => 'Earrings',
            'slug'        => 'earrings',
            'image'       => 'assets/images/2020/10/j3374ar013200.pw-1280-420x583.jpg',
            'description' => 'Organic hoops, architectural drops, and timeless golden studs.',
            'count'       => 6,
            'status'      => 'Active',
        ],
    ];
}

function get_sample_products() {
    return [
        [
            'id'             => 101,
            'sku'            => 'NCK-101',
            'name'           => 'Exuberant Golden Necklace',
            'description'    => 'Hand-crafted 18k gold vermeil organic drop pendant suspended on a delicate faceted chain.',
            'category'       => 'Necklaces',
            'price'          => 349.00,
            'discount_price' => 315.00,
            'stock'          => 14,
            'sales'          => 34,
            'status'         => 'Active',
            'images'         => [
                'assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg',
                'assets/images/2020/11/j3376co023200-2.pw-1280-2-420x584.jpg',
            ],
        ],
        [
            'id'             => 102,
            'sku'            => 'NCK-102',
            'name'           => 'Splash Golden Necklace',
            'description'    => 'Fluid sculptural cluster pendant inspired by sunlit water ripples in warm brushed gold.',
            'category'       => 'Necklaces',
            'price'          => 369.00,
            'discount_price' => null,
            'stock'          => 3,
            'sales'          => 29,
            'status'         => 'Active',
            'images'         => [
                'assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg',
                'assets/images/2020/10/j3370co033200-2.pw-1280-420x583.jpg',
            ],
        ],
        [
            'id'             => 103,
            'sku'            => 'NCK-103',
            'name'           => 'Moonrise Golden Necklace',
            'description'    => 'Minimalist crescent medallion necklace crafted for effortless evening layering.',
            'category'       => 'Necklaces',
            'price'          => 299.00,
            'discount_price' => null,
            'stock'          => 11,
            'sales'          => 21,
            'status'         => 'Active',
            'images'         => [
                'assets/images/2020/10/j3284co063200.pw-1280-420x583.jpg',
            ],
        ],
        [
            'id'             => 104,
            'sku'            => 'NCK-104',
            'name'           => 'Meandres Golden Necklace',
            'description'    => 'Artisan hammered ribbon silhouette in luminous warm rose-gold plating.',
            'category'       => 'Necklaces',
            'price'          => 419.00,
            'discount_price' => 380.00,
            'stock'          => 8,
            'sales'          => 17,
            'status'         => 'Active',
            'images'         => [
                'assets/images/2020/10/j3338co023200-2500.pw-270-420x583.jpg',
                'assets/images/2020/10/j3338co053200-2.pw-1280-420x583.jpg',
            ],
        ],
        [
            'id'             => 105,
            'sku'            => 'BRC-201',
            'name'           => 'Miro Jewelry Golden Bracelet',
            'description'    => 'Signature open cuff featuring twin organic medallions balanced with matte onyx accents.',
            'category'       => 'Bracelets',
            'price'          => 219.00,
            'discount_price' => null,
            'stock'          => 19,
            'sales'          => 41,
            'status'         => 'Active',
            'images'         => [
                'assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg',
                'assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-2.pw-1280-420x381.jpg',
            ],
        ],
        [
            'id'             => 106,
            'sku'            => 'BRC-202',
            'name'           => 'Arquitectura Golden Bracelet',
            'description'    => 'Modern geometric bangle inspired by Mediterranean stone arches and warm light.',
            'category'       => 'Bracelets',
            'price'          => 280.00,
            'discount_price' => 250.00,
            'stock'          => 2,
            'sales'          => 24,
            'status'         => 'Active',
            'images'         => [
                'assets/images/2020/10/j3371po033200.pw-1280-420x381.jpg',
                'assets/images/2020/10/arquitectura-420x381.jpg',
            ],
        ],
        [
            'id'             => 107,
            'sku'            => 'BRC-203',
            'name'           => 'Blossom Golden Bracelet',
            'description'    => 'Delicate botanical motif bracelet finished with satin-brushed 18k gold edges.',
            'category'       => 'Bracelets',
            'price'          => 260.00,
            'discount_price' => null,
            'stock'          => 0,
            'sales'          => 19,
            'status'         => 'Inactive',
            'images'         => [
                'assets/images/2020/09/j3370po013200.pw-1280-420x381.jpg',
                'assets/images/2020/10/blossom-420x381.jpg',
            ],
        ],
        [
            'id'             => 108,
            'sku'            => 'BRC-204',
            'name'           => 'Blush Golden Bracelet',
            'description'    => 'Featherlight articulated links designed for daily comfort and understated shimmer.',
            'category'       => 'Bracelets',
            'price'          => 240.00,
            'discount_price' => null,
            'stock'          => 9,
            'sales'          => 15,
            'status'         => 'Active',
            'images'         => [
                'assets/images/2020/10/j3376po043200.pw-1280-420x381.jpg',
                'assets/images/2020/10/blush-420x381.jpg',
            ],
        ],
        [
            'id'             => 109,
            'sku'            => 'EAR-301',
            'name'           => 'Curves Golden Earrings',
            'description'    => 'Signature asymmetrical sculptural drop earrings that catch light with every movement.',
            'category'       => 'Earrings',
            'price'          => 195.00,
            'discount_price' => null,
            'stock'          => 22,
            'sales'          => 38,
            'status'         => 'Active',
            'images'         => [
                'assets/images/2020/10/j3374ar013200.pw-1280-420x583.jpg',
                'assets/images/2020/10/j3374ar013200-2.pw-1280-420x583.jpg',
            ],
        ],
        [
            'id'             => 110,
            'sku'            => 'EAR-302',
            'name'           => 'Angel Hoops Golden Earrings',
            'description'    => 'Classic architectural hoops crafted with hollow-core 18k vermeil for effortless wear.',
            'category'       => 'Earrings',
            'price'          => 189.00,
            'discount_price' => 165.00,
            'stock'          => 4,
            'sales'          => 26,
            'status'         => 'Active',
            'images'         => [
                'assets/images/2020/10/j3343ar043200-2500.pw-1280-420x583.jpg',
                'assets/images/2020/10/j3343ar043200-2.pw-1280-420x583.jpg',
            ],
        ],
        [
            'id'             => 111,
            'sku'            => 'EAR-303',
            'name'           => 'Arquitectura Golden Earrings',
            'description'    => 'Statement geometric earrings celebrating clean gallery lines and mirror polish.',
            'category'       => 'Earrings',
            'price'          => 245.00,
            'discount_price' => null,
            'stock'          => 12,
            'sales'          => 14,
            'status'         => 'Active',
            'images'         => [
                'assets/images/2020/10/j3371ar033200.pw-1280-420x583.jpg',
            ],
        ],
        [
            'id'             => 112,
            'sku'            => 'EAR-304',
            'name'           => 'Portlligat Golden Earrings',
            'description'    => 'Textured coastal-inspired golden studs finished with protective anti-tarnish coat.',
            'category'       => 'Earrings',
            'price'          => 119.00,
            'discount_price' => null,
            'stock'          => 16,
            'sales'          => 22,
            'status'         => 'Active',
            'images'         => [
                'assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg',
            ],
        ],
    ];
}

function get_sample_orders() {
    return [
        [
            'id'             => 'ORD-1048',
            'customer_id'    => 1,
            'customer_name'  => 'Sophia Sterling',
            'customer_email' => 'sophia.sterling@example.com',
            'customer_phone' => '+1 (212) 555-0184',
            'shipping_addr'  => '742 Madison Avenue, Apt 4B, New York, NY 10065',
            'date'           => '2026-11-11',
            'total'          => 534.00,
            'subtotal'       => 534.00,
            'shipping'       => 0.00,
            'payment_status' => 'Paid',
            'order_status'   => 'Pending',
            'items'          => [
                [
                    'name'  => 'Exuberant Golden Necklace',
                    'qty'   => 1,
                    'price' => 315.00,
                    'image' => 'assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg',
                ],
                [
                    'name'  => 'Miro Jewelry Golden Bracelet',
                    'qty'   => 1,
                    'price' => 219.00,
                    'image' => 'assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg',
                ],
            ],
        ],
        [
            'id'             => 'ORD-1047',
            'customer_id'    => 2,
            'customer_name'  => 'Clara Montgomery',
            'customer_email' => 'clara.m@example.com',
            'customer_phone' => '+1 (310) 555-0149',
            'shipping_addr'  => '418 Rodeo Drive, Suite 210, Beverly Hills, CA 90210',
            'date'           => '2026-11-10',
            'total'          => 369.00,
            'subtotal'       => 369.00,
            'shipping'       => 0.00,
            'payment_status' => 'Paid',
            'order_status'   => 'Processing',
            'items'          => [
                [
                    'name'  => 'Splash Golden Necklace',
                    'qty'   => 1,
                    'price' => 369.00,
                    'image' => 'assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg',
                ],
            ],
        ],
        [
            'id'             => 'ORD-1046',
            'customer_id'    => 3,
            'customer_name'  => 'Elena Rostova',
            'customer_email' => 'elena.rostova@example.com',
            'customer_phone' => '+1 (415) 555-0192',
            'shipping_addr'  => '2150 Pacific Avenue, San Francisco, CA 94115',
            'date'           => '2026-11-09',
            'total'          => 445.00,
            'subtotal'       => 445.00,
            'shipping'       => 0.00,
            'payment_status' => 'Paid',
            'order_status'   => 'Shipped',
            'items'          => [
                [
                    'name'  => 'Arquitectura Golden Bracelet',
                    'qty'   => 1,
                    'price' => 250.00,
                    'image' => 'assets/images/2020/10/j3371po033200.pw-1280-420x381.jpg',
                ],
                [
                    'name'  => 'Curves Golden Earrings',
                    'qty'   => 1,
                    'price' => 195.00,
                    'image' => 'assets/images/2020/10/j3374ar013200.pw-1280-420x583.jpg',
                ],
            ],
        ],
        [
            'id'             => 'ORD-1045',
            'customer_id'    => 4,
            'customer_name'  => 'Amelia Vance',
            'customer_email' => 'amelia.vance@example.com',
            'customer_phone' => '+1 (305) 555-0161',
            'shipping_addr'  => '1400 Brickell Bay Drive, Miami, FL 33131',
            'date'           => '2026-11-08',
            'total'          => 299.00,
            'subtotal'       => 299.00,
            'shipping'       => 0.00,
            'payment_status' => 'Paid',
            'order_status'   => 'Delivered',
            'items'          => [
                [
                    'name'  => 'Moonrise Golden Necklace',
                    'qty'   => 1,
                    'price' => 299.00,
                    'image' => 'assets/images/2020/10/j3284co063200.pw-1280-420x583.jpg',
                ],
            ],
        ],
        [
            'id'             => 'ORD-1044',
            'customer_id'    => 5,
            'customer_name'  => 'Isabelle Laurent',
            'customer_email' => 'isabelle.laurent@example.com',
            'customer_phone' => '+1 (617) 555-0123',
            'shipping_addr'  => '88 Newbury Street, Boston, MA 02116',
            'date'           => '2026-11-06',
            'total'          => 165.00,
            'subtotal'       => 165.00,
            'shipping'       => 0.00,
            'payment_status' => 'Pending',
            'order_status'   => 'Pending',
            'items'          => [
                [
                    'name'  => 'Angel Hoops Golden Earrings',
                    'qty'   => 1,
                    'price' => 165.00,
                    'image' => 'assets/images/2020/10/j3343ar043200-2500.pw-1280-420x583.jpg',
                ],
            ],
        ],
        [
            'id'             => 'ORD-1043',
            'customer_id'    => 1,
            'customer_name'  => 'Sophia Sterling',
            'customer_email' => 'sophia.sterling@example.com',
            'customer_phone' => '+1 (212) 555-0184',
            'shipping_addr'  => '742 Madison Avenue, Apt 4B, New York, NY 10065',
            'date'           => '2026-10-29',
            'total'          => 245.00,
            'subtotal'       => 245.00,
            'shipping'       => 0.00,
            'payment_status' => 'Refunded',
            'order_status'   => 'Cancelled',
            'items'          => [
                [
                    'name'  => 'Arquitectura Golden Earrings',
                    'qty'   => 1,
                    'price' => 245.00,
                    'image' => 'assets/images/2020/10/j3371ar033200.pw-1280-420x583.jpg',
                ],
            ],
        ],
    ];
}

function get_sample_customers() {
    return [
        [
            'id'           => 1,
            'name'         => 'Sophia Sterling',
            'email'        => 'sophia.sterling@example.com',
            'phone'        => '+1 (212) 555-0184',
            'city'         => 'New York, NY',
            'address'      => '742 Madison Avenue, Apt 4B, New York, NY 10065',
            'joined'       => '2026-04-12',
            'orders_count' => 4,
            'total_spent'  => 1420.00,
            'last_order'   => '2026-11-11',
            'history'      => [
                ['id' => 'ORD-1048', 'date' => '2026-11-11', 'items' => 'Exuberant Golden Necklace, Miro Bracelet', 'total' => 534.00, 'status' => 'Pending'],
                ['id' => 'ORD-1043', 'date' => '2026-10-29', 'items' => 'Arquitectura Golden Earrings', 'total' => 245.00, 'status' => 'Cancelled'],
                ['id' => 'ORD-1019', 'date' => '2026-08-14', 'items' => 'Meandres Golden Necklace', 'total' => 380.00, 'status' => 'Delivered'],
                ['id' => 'ORD-0982', 'date' => '2026-05-03', 'items' => 'Blossom Golden Bracelet', 'total' => 261.00, 'status' => 'Delivered'],
            ],
        ],
        [
            'id'           => 2,
            'name'         => 'Clara Montgomery',
            'email'        => 'clara.m@example.com',
            'phone'        => '+1 (310) 555-0149',
            'city'         => 'Beverly Hills, CA',
            'address'      => '418 Rodeo Drive, Suite 210, Beverly Hills, CA 90210',
            'joined'       => '2026-06-20',
            'orders_count' => 2,
            'total_spent'  => 614.00,
            'last_order'   => '2026-11-10',
            'history'      => [
                ['id' => 'ORD-1047', 'date' => '2026-11-10', 'items' => 'Splash Golden Necklace', 'total' => 369.00, 'status' => 'Processing'],
                ['id' => 'ORD-1012', 'date' => '2026-07-19', 'items' => 'Arquitectura Golden Earrings', 'total' => 245.00, 'status' => 'Delivered'],
            ],
        ],
        [
            'id'           => 3,
            'name'         => 'Elena Rostova',
            'email'        => 'elena.rostova@example.com',
            'customer_vip' => true,
            'phone'        => '+1 (415) 555-0192',
            'city'         => 'San Francisco, CA',
            'address'      => '2150 Pacific Avenue, San Francisco, CA 94115',
            'joined'       => '2026-02-05',
            'orders_count' => 3,
            'total_spent'  => 984.00,
            'last_order'   => '2026-11-09',
            'history'      => [
                ['id' => 'ORD-1046', 'date' => '2026-11-09', 'items' => 'Arquitectura Bracelet, Curves Earrings', 'total' => 445.00, 'status' => 'Shipped'],
                ['id' => 'ORD-1004', 'date' => '2026-06-11', 'items' => 'Moonrise Golden Necklace', 'total' => 299.00, 'status' => 'Delivered'],
                ['id' => 'ORD-0965', 'date' => '2026-03-22', 'items' => 'Blush Golden Bracelet', 'total' => 240.00, 'status' => 'Delivered'],
            ],
        ],
        [
            'id'           => 4,
            'name'         => 'Amelia Vance',
            'email'        => 'amelia.vance@example.com',
            'phone'        => '+1 (305) 555-0161',
            'city'         => 'Miami, FL',
            'address'      => '1400 Brickell Bay Drive, Miami, FL 33131',
            'joined'       => '2026-09-01',
            'orders_count' => 1,
            'total_spent'  => 299.00,
            'last_order'   => '2026-11-08',
            'history'      => [
                ['id' => 'ORD-1045', 'date' => '2026-11-08', 'items' => 'Moonrise Golden Necklace', 'total' => 299.00, 'status' => 'Delivered'],
            ],
        ],
        [
            'id'           => 5,
            'name'         => 'Isabelle Laurent',
            'email'        => 'isabelle.laurent@example.com',
            'phone'        => '+1 (617) 555-0123',
            'city'         => 'Boston, MA',
            'address'      => '88 Newbury Street, Boston, MA 02116',
            'joined'       => '2026-10-18',
            'orders_count' => 1,
            'total_spent'  => 165.00,
            'last_order'   => '2026-11-06',
            'history'      => [
                ['id' => 'ORD-1044', 'date' => '2026-11-06', 'items' => 'Angel Hoops Golden Earrings', 'total' => 165.00, 'status' => 'Pending'],
            ],
        ],
    ];
}

function get_sample_messages() {
    return [
        [
            'id'      => 1,
            'name'    => 'Victoria Kensington',
            'email'   => 'victoria.k@example.com',
            'phone'   => '+1 (212) 555-0177',
            'subject' => 'Custom chain length inquiry for Exuberant Necklace',
            'message' => 'Hello Atelier team, I would love to order the Exuberant Golden Necklace for an upcoming anniversary. Could you advise whether an 18-inch chain extender is available prior to dispatch?',
            'date'    => '2026-11-11 09:40',
            'status'  => 'Unread',
        ],
        [
            'id'      => 2,
            'name'    => 'Margot Delacroix',
            'email'   => 'margot.d@example.com',
            'phone'   => '+1 (312) 555-0133',
            'subject' => 'Bridal gift packaging & personal note',
            'message' => 'Good morning, I placed an inquiry regarding complimentary gift boxing for three pairs of Curves Golden Earrings. Do all items ship inside individual suede pouches?',
            'date'    => '2026-11-10 16:15',
            'status'  => 'Unread',
        ],
        [
            'id'      => 3,
            'name'    => 'Natalie Bennett',
            'email'   => 'natalie.b@example.com',
            'phone'   => '+1 (206) 555-0108',
            'subject' => 'Restock timing for Blossom Golden Bracelet',
            'message' => 'Hi there, I noticed the Blossom Golden Bracelet is currently out of stock. When do you expect your next studio batch to become available?',
            'date'    => '2026-11-08 11:20',
            'status'  => 'Read',
        ],
        [
            'id'      => 4,
            'name'    => 'Charlotte Mercer',
            'email'   => 'charlotte.m@example.com',
            'phone'   => '+1 (646) 555-0155',
            'subject' => 'Care instructions for 18k gold vermeil',
            'message' => 'Thank you for my recent order! Could you share your recommended polishing cloth care guidelines for daily wear?',
            'date'    => '2026-11-05 14:05',
            'status'  => 'Replied',
        ],
    ];
}

function get_sample_settings() {
    return [
        'store_name'          => 'LOREM Atelier',
        'store_tagline'       => 'Fine Handcrafted Jewellery',
        'store_email'         => 'concierge@loremstore.example',
        'store_phone'         => '+1 (212) 555-0100',
        'currency'            => 'USD ($)',
        'low_stock_threshold' => 5,
        'free_shipping_min'   => 250.00,
        'order_notifications' => true,
        'low_stock_alerts'    => true,
        'admin_name'          => 'Studio Director',
        'admin_email'         => 'admin@loremstore.example',
    ];
}

