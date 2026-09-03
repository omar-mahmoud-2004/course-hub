<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Review;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CourseHubSampleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clear previous courses, lessons, quizzes, reviews, and enrollments
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Review::truncate();
        Quiz::truncate();
        Lesson::truncate();
        Course::truncate();
        if (class_exists(Enrollment::class)) {
            Enrollment::truncate();
        }
        DB::table('enrollments')->truncate();
        DB::table('progress')->truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Seed Categories
        $categories = [
            ['name' => 'Web Development', 'icon' => null],
            ['name' => 'Mobile App Development', 'icon' => null],
            ['name' => 'Data Science & AI', 'icon' => null],
            ['name' => 'Cloud & DevOps', 'icon' => null],
            ['name' => 'UI / UX Design', 'icon' => null],
            ['name' => 'Cyber Security', 'icon' => null],
        ];

        $catMap = [];
        foreach ($categories as $cat) {
            $created = Category::create($cat);
            $catMap[$created->name] = $created->id;
        }

        // 3. Seed Professional Instructors
        $teachers = [
            [
                'name' => 'Omar Mahmoud',
                'email' => 'omar.instructor@coursehub.com',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
            ],
            [
                'name' => 'Dr. Alex Rivera',
                'email' => 'alex.rivera@coursehub.com',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
            ],
            [
                'name' => 'Sarah Jenkins',
                'email' => 'sarah.jenkins@coursehub.com',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@coursehub.com',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
            ],
        ];

        $teacherMap = [];
        foreach ($teachers as $t) {
            $user = User::updateOrCreate(['email' => $t['email']], $t);
            $teacherMap[$user->name] = $user->id;
        }

        // 4. Seed Test Students for Reviews & Enrollments
        $students = [
            ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => Hash::make('password123'), 'role' => 'student'],
            ['name' => 'Emily Watson', 'email' => 'emily@example.com', 'password' => Hash::make('password123'), 'role' => 'student'],
            ['name' => 'Liam Brown', 'email' => 'liam@example.com', 'password' => Hash::make('password123'), 'role' => 'student'],
        ];

        $studentIds = [];
        foreach ($students as $s) {
            $student = User::updateOrCreate(['email' => $s['email']], $s);
            $studentIds[] = $student->id;
        }

        // 5. Seed 6 Professional Courses
        $coursesData = [
            [
                'title' => 'Full-Stack Web Development with Laravel & Vue',
                'description' => 'Master modern full-stack web applications from scratch. Learn Laravel 12 backend architecture, REST APIs, Vue.js components, authentication, and database optimization.',
                'price' => 49.99,
                'category_id' => $catMap['Web Development'],
                'teacher_id' => $teacherMap['Omar Mahmoud'],
                'image' => 'upload/course_fullstack_laravel.jpg',
                'lessons' => [
                    ['title' => '1. Course Orientation & Environment Setup', 'description' => 'Setup PHP, Composer, Node.js, and create a brand new Laravel application.', 'video_url' => 'https://www.youtube.com/watch?v=MYyJ4PuL4pY', 'duration' => '18 mins'],
                    ['title' => '2. Routing, Controllers & Blade Templating', 'description' => 'Deep dive into request lifecycles, route parameters, controllers, and Blade syntax.', 'video_url' => 'https://www.youtube.com/watch?v=ImtZ5yENzgE', 'duration' => '28 mins'],
                    ['title' => '3. Eloquent Relationships & Database Migrations', 'description' => 'Designing relational databases with Eloquent: hasMany, belongsTo, and migrations.', 'video_url' => 'https://www.youtube.com/watch?v=376vZ1A74fs', 'duration' => '35 mins'],
                ],
                'quizzes' => [
                    ['question' => 'What artisan command generates a new controller with resource methods?', 'answer' => 'php artisan make:controller --resource', 'correct_answer' => 'php artisan make:controller --resource'],
                    ['question' => 'Which directory stores Blade view templates in Laravel?', 'answer' => 'resources/views', 'correct_answer' => 'resources/views'],
                ],
                'reviews' => [
                    ['student_index' => 0, 'rating' => 5, 'comment' => 'One of the best Laravel courses available! The practical examples are spot on.'],
                    ['student_index' => 1, 'rating' => 5, 'comment' => 'Crystal clear explanations and very responsive instructor. Highly recommended!'],
                ]
            ],
            [
                'title' => 'Python for Data Science & Machine Learning Bootcamp',
                'description' => 'A comprehensive guide to data analysis and predictive modeling. Covers NumPy, Pandas, Matplotlib, Scikit-Learn, and Deep Learning neural networks.',
                'price' => 69.99,
                'category_id' => $catMap['Data Science & AI'],
                'teacher_id' => $teacherMap['Dr. Alex Rivera'],
                'image' => 'upload/course_data_science.jpg',
                'lessons' => [
                    ['title' => '1. Python Fundamentals for Data Analysis', 'description' => 'Core Python data structures, list comprehensions, and data wrangling tools.', 'video_url' => 'https://www.youtube.com/watch?v=LHBE6Q9XlzI', 'duration' => '24 mins'],
                    ['title' => '2. Mastering Pandas & Data Visualization', 'description' => 'DataFrame manipulations, handling missing values, and plotting with Seaborn.', 'video_url' => 'https://www.youtube.com/watch?v=vmEHCJofslg', 'duration' => '32 mins'],
                    ['title' => '3. Building Supervised Learning Models', 'description' => 'Linear regression, decision trees, model training, and performance evaluation metrics.', 'video_url' => 'https://www.youtube.com/watch?v=i_LwzRVP7bg', 'duration' => '40 mins'],
                ],
                'quizzes' => [
                    ['question' => 'Which Python library is primarily used for multi-dimensional numerical arrays?', 'answer' => 'numpy', 'correct_answer' => 'numpy'],
                    ['question' => 'What is the primary object structure used in Pandas?', 'answer' => 'dataframe', 'correct_answer' => 'dataframe'],
                ],
                'reviews' => [
                    ['student_index' => 1, 'rating' => 5, 'comment' => 'Dr. Rivera simplifies the hardest ML algorithms into intuitive steps. 10/10!'],
                    ['student_index' => 2, 'rating' => 4, 'comment' => 'Great real-world datasets and comprehensive projects.'],
                ]
            ],
            [
                'title' => 'Mastering Flutter & Dart: Build iOS & Android Apps',
                'description' => 'Build high-performance, responsive native mobile applications for iOS and Android using Flutter 3, Dart, state management with Bloc, and Firebase cloud integrations.',
                'price' => 39.99,
                'category_id' => $catMap['Mobile App Development'],
                'teacher_id' => $teacherMap['Omar Mahmoud'],
                'image' => 'upload/course_flutter.jpg',
                'lessons' => [
                    ['title' => '1. Introduction to Dart Language & Flutter Widgets', 'description' => 'Understanding Stateless and Stateful widgets, layout building, and hot reload.', 'video_url' => 'https://www.youtube.com/watch?v=1ukSR1GRtMU', 'duration' => '22 mins'],
                    ['title' => '2. State Management with Provider & Bloc', 'description' => 'Separating business logic from UI and maintaining scalable application states.', 'video_url' => 'https://www.youtube.com/watch?v=oxeYeMH6-48', 'duration' => '36 mins'],
                    ['title' => '3. REST API Integration & Firebase Authentication', 'description' => 'Connecting Flutter to backend services and handling user sessions gracefully.', 'video_url' => 'https://www.youtube.com/watch?v=VPvVD8t02U8', 'duration' => '30 mins'],
                ],
                'quizzes' => [
                    ['question' => 'What command is used to verify Flutter installation and dependencies?', 'answer' => 'flutter doctor', 'correct_answer' => 'flutter doctor'],
                ],
                'reviews' => [
                    ['student_index' => 0, 'rating' => 5, 'comment' => 'Eng. Omar creates very engaging mobile tutorials. Built my first app in 2 weeks!'],
                ]
            ],
            [
                'title' => 'Modern UI/UX Design Masterclass with Figma',
                'description' => 'From wireframes to interactive high-fidelity prototypes. Learn user research, typography, color harmony, responsive layout grids, and scalable design systems.',
                'price' => 29.99,
                'category_id' => $catMap['UI / UX Design'],
                'teacher_id' => $teacherMap['Michael Chen'],
                'image' => 'upload/course_uiux_figma.jpg',
                'lessons' => [
                    ['title' => '1. Design Fundamentals: Typography & Visual Hierarchy', 'description' => 'Creating contrast, optical balance, and choosing font pairings for web and mobile.', 'video_url' => 'https://www.youtube.com/watch?v=FTFaQWZBqQ8', 'duration' => '20 mins'],
                    ['title' => '2. Auto-Layout & Component Variants in Figma', 'description' => 'Master Figma auto-layout 5.0, nested component sets, and interactive states.', 'video_url' => 'https://www.youtube.com/watch?v=NrKX46DzkGQ', 'duration' => '34 mins'],
                    ['title' => '3. Prototyping Micro-Interactions & Usability Testing', 'description' => 'Designing realistic animations, smart animations, and conducting user interviews.', 'video_url' => 'https://www.youtube.com/watch?v=c9Wg6Cb_YlU', 'duration' => '26 mins'],
                ],
                'quizzes' => [
                    ['question' => 'Which Figma feature enables responsive dynamic resizing of cards and buttons?', 'answer' => 'auto layout', 'correct_answer' => 'auto layout'],
                ],
                'reviews' => [
                    ['student_index' => 2, 'rating' => 5, 'comment' => 'The design system section completely transformed how I work with dev teams.'],
                ]
            ],
            [
                'title' => 'AWS Cloud & DevOps Engineering: Docker, K8s & CI/CD',
                'description' => 'Deploy enterprise scalable cloud architectures on Amazon Web Services. Containerize applications with Docker, orchestrate with Kubernetes, and automate deployments with CI/CD.',
                'price' => 79.99,
                'category_id' => $catMap['Cloud & DevOps'],
                'teacher_id' => $teacherMap['Sarah Jenkins'],
                'image' => 'upload/course_devops_aws.jpg',
                'lessons' => [
                    ['title' => '1. AWS Core Infrastructure: EC2, S3 & VPCs', 'description' => 'Setting up compute instances, scalable object storage, and secure virtual networks.', 'video_url' => 'https://www.youtube.com/watch?v=ulprqHHWlng', 'duration' => '30 mins'],
                    ['title' => '2. Containerization with Docker & Multi-Stage Builds', 'description' => 'Writing efficient Dockerfiles, volume mounts, networks, and docker-compose.', 'video_url' => 'https://www.youtube.com/watch?v=fqMOX6JJhGo', 'duration' => '38 mins'],
                    ['title' => '3. CI/CD Pipelines with GitHub Actions', 'description' => 'Automate testing, container building, and deployment upon pushing to git.', 'video_url' => 'https://www.youtube.com/watch?v=R8_veQiYBjI', 'duration' => '32 mins'],
                ],
                'quizzes' => [
                    ['question' => 'Which AWS service provides scalable cloud compute capacity?', 'answer' => 'ec2', 'correct_answer' => 'ec2'],
                ],
                'reviews' => [
                    ['student_index' => 0, 'rating' => 5, 'comment' => 'Clear, professional, and industry-grade DevOps best practices. Absolutely stellar.'],
                ]
            ],
            [
                'title' => 'Ethical Hacking & Modern Cyber Security Fundamentals',
                'description' => 'Master penetration testing, vulnerability assessment, network security, and defense tactics. Understand the OWASP Top 10 vulnerabilities and ethical hacking toolsets.',
                'price' => 0.00,
                'category_id' => $catMap['Cyber Security'],
                'teacher_id' => $teacherMap['Dr. Alex Rivera'],
                'image' => 'upload/course_cyber_security.jpg',
                'lessons' => [
                    ['title' => '1. Introduction to Ethical Hacking & Kali Linux', 'description' => 'Security mindset, legal frameworks, and essential networking utilities.', 'video_url' => 'https://www.youtube.com/watch?v=3Kq1MIfTWCE', 'duration' => '25 mins'],
                    ['title' => '2. Network Scanning & Reconnaissance', 'description' => 'Port scanning with Nmap, banner grabbing, and active vulnerability discovery.', 'video_url' => 'https://www.youtube.com/watch?v=4t4kBkMsDbY', 'duration' => '35 mins'],
                    ['title' => '3. Web Application Vulnerabilities & OWASP Top 10', 'description' => 'SQL injection, Cross-Site Scripting (XSS), and secure coding practices.', 'video_url' => 'https://www.youtube.com/watch?v=2_lswM1S264', 'duration' => '42 mins'],
                ],
                'quizzes' => [
                    ['question' => 'Which port is standard for encrypted HTTPS web traffic?', 'answer' => '443', 'correct_answer' => '443'],
                ],
                'reviews' => [
                    ['student_index' => 1, 'rating' => 5, 'comment' => 'Can not believe this course is free! Incredible value and depth.'],
                ]
            ],
        ];

        foreach ($coursesData as $cData) {
            $lessons = $cData['lessons'];
            $quizzes = $cData['quizzes'];
            $reviews = $cData['reviews'];
            unset($cData['lessons'], $cData['quizzes'], $cData['reviews']);

            $course = Course::create($cData);

            // Add Lessons
            foreach ($lessons as $lesson) {
                $lesson['course_id'] = $course->id;
                Lesson::create($lesson);
            }

            // Add Quizzes
            foreach ($quizzes as $quiz) {
                $quiz['course_id'] = $course->id;
                Quiz::create($quiz);
            }

            // Add Reviews
            foreach ($reviews as $rev) {
                Review::create([
                    'course_id' => $course->id,
                    'student_id' => $studentIds[$rev['student_index']],
                    'rating' => $rev['rating'],
                    'comment' => $rev['comment'],
                ]);
            }

            // Enroll the test students
            foreach ($studentIds as $sid) {
                DB::table('enrollments')->insertOrIgnore([
                    'course_id' => $course->id,
                    'user_id' => $sid,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
