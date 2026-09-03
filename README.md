# Course Hub - منصة تعليمية متكاملة 🎓

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>

منصة تعليمية تفاعلية مبنية باستخدام إطار العمل **Laravel**، مصممة لإدارة الدورات التدريبية بكفاءة وتوفير تجربة تعليمية سلسة ومتقدمة للطلاب والمدرسين والإدارة.

---

## 🌟 المميزات الرئيسية (Key Features)

### 👨‍🎓 لوحة تحكم الطالب (Student Dashboard)
- استعراض وتصفح الكورسات المتاحة والاشتراك فيها بسهولة.
- واجهة لمتابعة الدروس والوسائط التعليمية.
- متابعة نسبة التقدم وإكمال الدروس (Progress Tracking).
- إجراء الاختبارات القصيرة (Quizzes) واستعراض النتائج.
- تعديل الملف الشخصي وإدارة الكورسات المشترك بها.

### 👨‍🏫 لوحة تحكم المدرس (Teacher Dashboard)
- إدارة الكورسات الخاصة بالمدرس (إضافة، تعديل، حذف).
- إضافة الدروس والمحتوى التعليمي لكل كورس.
- متابعة الطلاب المشتركين في الكورسات وتقييماتهم.

### 🛡️ لوحة الإدارة (Admin Panel)
- إدارة المستخدمين (الطلاب، المدرسين، مدراء النظام) وتعيين الصلاحيات.
- إدارة جميع الكورسات والتصنيفات (Categories).
- مراجعة وإدارة التقييمات (Reviews Moderation).
- إحصائيات عامة عن المنصة.

### 🎨 التصميم وتجربة المستخدم (UI/UX)
- تصميم متجاوب 100% متوافق مع كافة مقاسات الشاشات والهواتف.
- دعم الوضع الليلي والنهاري (Dark & Light Mode).
- واجهات عصرية وبسيطة مدعومة بـ Bootstrap 5 و FontAwesome.

---

## 🛠️ متطلبات التشغيل (Prerequisites)

- **PHP** >= 8.2 (مفعل به ملحقات PDO, OpenSSL, Mbstring, cURL)
- **Composer**
- **Node.js** & **NPM**
- **MySQL** أو **MariaDB** (عبر XAMPP أو بيئة مستقلة)

---

## 🚀 طريقة التثبيت والتشغيل (Installation Guide)

### 1. استنساخ المستودع (Clone Repository)
```bash
git clone https://github.com/omar-mahmoud-2004/course-hub.git
cd course-hub
```

### 2. تثبيت الحزم والمكتبات (Install Dependencies)
```bash
composer install
npm install
```

### 3. إعداد ملف البيئة (Environment Setup)
قم بنسخ ملف `.env.example` إلى `.env`:
```bash
cp .env.example .env
```
ثم قم بتوليد مفتاح التطبيق:
```bash
php artisan key:generate
```

### 4. إعداد قاعدة البيانات (Database Configuration)
عدّل بيانات الاتصال بقاعدة البيانات في ملف `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=courses-platform
DB_USERNAME=root
DB_PASSWORD=
```

ثم قم بإنشاء الجداول وتشغيل البيانات التجريبية:
```bash
php artisan migrate --seed
```

### 5. ربط مجلد التخزين (Storage Link)
لضمان ظهور الصور والملفات المرفوعة:
```bash
php artisan storage:link
```

### 6. بناء ملفات الواجهة والتشغيل (Build & Run)
في نافذة تيرمينال أولى:
```bash
npm run dev
# أو للإنتاج: npm run build
```

في نافذة تيرمينال ثانية لتشغيل سيرفر لارافيل:
```bash
php artisan serve
```

افتح المتصفح وتوجه إلى:
```
http://127.0.0.1:8000
```

---

## 📁 هيكلة المشروع (Project Structure)

```text
courses-platform/
├── app/                  # منطق التطبيق (Models, Controllers, Middleware)
├── database/             # ملفات التهجير والـ Seeders
├── public/               # الملفات العامة المتاحة للزوار (CSS, JS, Assets)
├── resources/            # ملفات العرض Blade وملفات Vite
│   └── views/
│       ├── admin/        # قوالب لوحة الأدمن
│       ├── auth/         # قوالب تسجيل الدخول والتسجيل
│       ├── courses/      # قوالب الكورسات
│       ├── student/      # قوالب لوحة الطالب
│       └── teacher/      # قوالب لوحة المدرس
├── routes/               # ملفات المسارات (web.php, api.php)
└── storage/              # الملفات المرفوعة، الجلسات، والسجلات
```

---

## 👨‍💻 المساهمة والتطوير (Author)

تم التطوير بواسطة **[عمر محمود](https://github.com/omar-mahmoud-2004)**.  
جميع الحقوق محفوظة &copy; 2026.
