การติดตั้งใช้งานบน XAMPP:
1. แตกไฟล์ zip ลงใน htdocs (เช่น C:\xampp\htdocs\online_store_blue)
2. สร้างฐานข้อมูลชื่อ `online_store` (หรือแก้ inc/config.php ให้ตรง)
3. นำเข้าไฟล์ sql/schema.sql ในโฟลเดอร์ sql/ (ใช้ phpMyAdmin หรือ mysql client)
4. เปิด http://localhost/online_store_blue/index.php
5. ค่าเริ่มต้น: ผู้ใช้ admin (email: admin@example.com, password: adminpass)

หมายเหตุ: Tailwind ถูกโหลดจาก CDN เพื่อความสะดวกในการรันบน XAMPP. รูปภาพตัวอย่างอยู่ที่ assets/images/placeholder.png - แทนที่ด้วยรูปจริงตามต้องการ.
