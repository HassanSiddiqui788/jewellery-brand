-- Proposed Initial Seed for JARWAYA JEWELS Products
-- 6 Products across 3 Categories (2 Necklaces, 2 Bracelets, 2 Earrings)
-- Pending User Confirmation / Approval

INSERT INTO products (id, category_id, product_name, product_slug, description, price, discount_price, main_image, stock_quantity, status)
VALUES
-- Necklaces (Category ID 1)
(1, 1, 'Splash Golden Necklace', 'splash-golden-necklace', 
 'A fluid sculptural cluster pendant inspired by ripples of sunlight, finished with an elegant satin texture.', 
 28500.00, NULL, 'assets/images/2020/02/j3370co033200.pw-1280-420x583.jpg', 15, 'active'),

(2, 1, 'Exuberant Golden Necklace', 'exuberant-golden-necklace', 
 'An organic teardrop silhouette suspended gracefully from a fine faceted chain for evening sophistication.', 
 24900.00, NULL, 'assets/images/2020/10/j3376co023200.pw-1280-420x583.jpg', 12, 'active'),

-- Bracelets (Category ID 2)
(3, 2, 'Miro Jewelry Golden Bracelet', 'miro-jewelry-golden-bracelet', 
 'An iconic open-cuff bracelet featuring harmonious contoured medallions designed for everyday elegance.', 
 18500.00, NULL, 'assets/images/2020/10/m-9-9-9-9-p-o-1-5-3-2-0-0.pw-1280-420x381.jpg', 20, 'active'),

(4, 2, 'Arquitectura Golden Bracelet', 'arquitectura-golden-bracelet', 
 'A geometric structured bangle inspired by timeless architectural curves and balanced proportion.', 
 21000.00, NULL, 'assets/images/2020/10/j3371po033200.pw-1280-420x381.jpg', 8, 'active'),

-- Earrings (Category ID 3)
(5, 3, 'Curves Golden Earrings', 'curves-golden-earrings', 
 'Asymmetrical sculptural drops crafted to catch and reflect light with every graceful movement.', 
 14500.00, NULL, 'assets/images/2020/10/j3374ar013200.pw-1280-420x583.jpg', 25, 'active'),

(6, 3, 'Portlligat Golden Earrings', 'portlligat-golden-earrings', 
 'Organic textured studs inspired by coastal contours, offering subtle sophistication for daily wear.', 
 11500.00, NULL, 'assets/images/2020/10/j3378ar043200.pw-1280-420x583.jpg', 18, 'active')

ON DUPLICATE KEY UPDATE
    category_id = VALUES(category_id),
    product_name = VALUES(product_name),
    description = VALUES(description),
    price = VALUES(price),
    discount_price = VALUES(discount_price),
    main_image = VALUES(main_image),
    stock_quantity = VALUES(stock_quantity),
    status = VALUES(status);
