<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_keahlians')->insert([
            // Web Development
            ['keahlian_nama' => 'Frontend Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Backend Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Full Stack Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'React Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Vue.js Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Angular Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Node.js Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'PHP Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Laravel Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'CodeIgniter Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Mobile Development
            ['keahlian_nama' => 'Android Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'iOS Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Flutter Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'React Native Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Xamarin Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Ionic Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Kotlin Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Swift Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Game Development
            ['keahlian_nama' => 'Game Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Unity Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Unreal Engine Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Game Designer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => '3D Game Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => '2D Game Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Mobile Game Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Design & Creative
            ['keahlian_nama' => 'UI/UX Designer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Graphic Designer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Web Designer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Motion Graphics Designer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => '3D Designer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Product Designer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Digital Illustrator', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Video Editor', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Photographer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Data & Analytics
            ['keahlian_nama' => 'Data Scientist', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Data Analyst', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Business Intelligence', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Machine Learning Engineer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'AI Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Big Data Specialist', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Python Data Analyst', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'R Programming', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Programming Languages
            ['keahlian_nama' => 'Java Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Python Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'C++ Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'C# Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'JavaScript Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'TypeScript Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Go Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Rust Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Ruby Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Scala Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Database & Infrastructure
            ['keahlian_nama' => 'Database Administrator', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'MySQL Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'PostgreSQL Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'MongoDB Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Redis Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'DevOps Engineer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Cloud Engineer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'AWS Specialist', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Google Cloud Specialist', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Azure Specialist', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Security & Testing
            ['keahlian_nama' => 'Software Tester (QA)', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Cybersecurity Specialist', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Penetration Tester', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Security Analyst', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Automation Tester', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Performance Tester', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Network & System
            ['keahlian_nama' => 'Network Administrator', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'System Administrator', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Linux Administrator', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Windows Administrator', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Docker Specialist', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Kubernetes Specialist', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Emerging Technologies
            ['keahlian_nama' => 'Blockchain Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'IoT Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'AR/VR Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Robotics Engineer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Computer Vision', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Natural Language Processing', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Business & Management
            ['keahlian_nama' => 'Project Manager', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Product Manager', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Scrum Master', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Business Analyst', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Digital Marketing', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'SEO Specialist', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Content Creator', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Social Media Manager', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Specialized Fields
            ['keahlian_nama' => 'E-commerce Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'CRM Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'ERP Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Salesforce Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'WordPress Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Shopify Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Magento Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Technical Writing & Documentation
            ['keahlian_nama' => 'Technical Writer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'API Documentation', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Software Documentation', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Hardware & Electronics
            ['keahlian_nama' => 'Hardware Engineer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Electronics Engineer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Embedded Systems', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Firmware Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'PCB Designer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            
            // Additional Specialized Skills
            ['keahlian_nama' => 'Microservices Architecture', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'API Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'GraphQL Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'REST API Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Web3 Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Smart Contract Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Cryptocurrency Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Game AI Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'Educational Technology', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
            ['keahlian_nama' => 'FinTech Developer', 'keahlian_visible' => true, 'created_at' => Carbon::createFromTimestamp(rand(Carbon::create(2020, 1, 1)->timestamp, Carbon::create(2025, 12, 31)->timestamp))],
        ]);
    }
}