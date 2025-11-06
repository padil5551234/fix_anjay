# Tutor System Documentation

## Overview
A complete tutor management system has been successfully integrated into the Bocah Kedinasan tryout platform. This system allows tutors to manage their classes, materials, and interact with students through a beautifully designed dashboard.

## System Components

### 1. Database Structure
- **Users Table**: Extended to support tutor role using Spatie Permission package
- **Roles**: 'tutor' role created for tutor users
- **Relationships**: 
  - Tutors can have multiple LiveClasses
  - Tutors can have multiple Materials
  - Uses existing users table with role-based permissions

### 2. Authentication & Authorization
- **Role**: `tutor`
- **Middleware**: `role:tutor` applied to all tutor routes
- **Routes Prefix**: `/tutor`
- **Access Control**: Only users with 'tutor' role can access tutor dashboard

### 3. Dashboard Features

#### Statistics Cards
- **Total Kelas**: Count of all classes created by tutor
- **Kelas Mendatang**: Scheduled upcoming classes
- **Kelas Selesai**: Completed classes
- **Total Materi**: All materials uploaded by tutor
- **Materi Publik**: Publicly available materials
- **Total Views**: Sum of views across all materials

#### Quick Actions
- Create new class
- Upload material
- View all classes
- Manage materials

#### Recent Activities
- **Upcoming Classes Table**: Shows next 5 scheduled classes with:
  - Title and batch information
  - Date and time
  - Status badges
  - Action buttons (View, Edit)
  
- **Recent Materials List**: Shows last 5 materials with:
  - Material type icon (video/document/link)
  - Title
  - Public/Private status
  - Creation date and view count

#### Tips Section
- Professional guidance for tutors
- Best practices for teaching
- Material management tips

### 4. Styling & UI
- **Framework**: Stisla Admin Template (Bootstrap-based)
- **Design**: Modern, clean, and professional
- **Colors**: 
  - Primary: Blue (#6777ef)
  - Success: Green (#28a745)
  - Warning: Yellow (#ffc107)
  - Info: Cyan (#17a2b8)
- **Components**:
  - Statistics cards with icons
  - Animated card entries
  - Responsive design (mobile-friendly)
  - Interactive tooltips
  - Color-coded status badges
  - Empty state designs

## Installation & Setup

### Test Credentials
Three test tutor accounts have been created:

1. **Tutor 1**
   - Email: `tutor1@example.com`
   - Password: `password123`

2. **Tutor 2**
   - Email: `tutor2@example.com`
   - Password: `password123`

3. **Tutor 3**
   - Email: `tutor3@example.com`
   - Password: `password123`

### Creating New Tutor Users

#### Option 1: Using Seeder
```bash
php artisan db:seed --class=TutorSeeder
```

#### Option 2: Manual Creation
```php
use App\Models\User;
use Spatie\Permission\Models\Role;

// Create user
$user = User::create([
    'name' => 'Tutor Name',
    'email' => 'tutor@example.com',
    'password' => 'password', // Will be auto-hashed by model
    'email_verified_at' => now(),
    'status' => 'active',
]);

// Assign tutor role
$user->assignRole('tutor');
```

## Routes

### Tutor Routes
All tutor routes are protected by authentication and role verification:

```php
// Dashboard
GET /tutor/dashboard

// Live Classes
GET /tutor/live-classes
GET /tutor/live-classes/create
POST /tutor/live-classes
GET /tutor/live-classes/{id}
GET /tutor/live-classes/{id}/edit
PUT /tutor/live-classes/{id}
DELETE /tutor/live-classes/{id}
POST /tutor/live-classes/{id}/start
POST /tutor/live-classes/{id}/end
POST /tutor/live-classes/{id}/cancel

// Materials
GET /tutor/materials
GET /tutor/materials/create
POST /tutor/materials
GET /tutor/materials/{id}
GET /tutor/materials/{id}/edit
PUT /tutor/materials/{id}
DELETE /tutor/materials/{id}
GET /tutor/materials/{id}/download
POST /tutor/materials/{id}/toggle-featured
POST /tutor/materials/{id}/toggle-public
POST /tutor/materials/youtube-info

// Bank Soal
GET /tutor/bank-soal
GET /tutor/bank-soal/create
POST /tutor/bank-soal
GET /tutor/bank-soal/{id}
GET /tutor/bank-soal/{id}/edit
PUT /tutor/bank-soal/{id}
DELETE /tutor/bank-soal/{id}
GET /tutor/bank-soal/{id}/download
```

## Controller

### TutorController
Location: `app/Http/Controllers/Tutor/TutorController.php`

**Methods:**
- `dashboard()`: Displays tutor dashboard with statistics and activities

**Statistics Calculated:**
- Total classes count
- Upcoming classes (status: scheduled, future date)
- Completed classes (status: completed)
- Total materials count
- Public materials count
- Total views across all materials

## Views

### Dashboard View
Location: `resources/views/tutor/dashboard.blade.php`

**Sections:**
1. Welcome Header with date
2. Statistics Cards (4 cards)
3. Secondary Stats & Quick Actions
4. Upcoming Classes Table
5. Recent Materials List
6. Tips for Tutors

## Seeder

### TutorSeeder
Location: `database/seeders/TutorSeeder.php`

**Features:**
- Creates 'tutor' role if doesn't exist
- Creates 3 test tutor users
- Assigns tutor role to users
- Prevents duplicate creation
- Displays login credentials after seeding

## User Model Extensions

### Relationships Added
```php
// Get all live classes for tutor
public function liveClasses()
{
    return $this->hasMany(LiveClass::class, 'tutor_id', 'id');
}

// Get all materials for tutor
public function materials()
{
    return $this->hasMany(Material::class, 'tutor_id', 'id');
}

// Check if user is tutor
public function isTutor()
{
    return $this->hasRole('tutor');
}
```

## Testing

### Access Dashboard
1. Start development server:
   ```bash
   php artisan serve
   ```

2. Navigate to: `http://localhost:8000/login`

3. Login with test credentials:
   - Email: `tutor1@example.com`
   - Password: `password123`

4. After successful login, you'll be redirected based on your role
   - Tutors → `/tutor/dashboard`

5. Or directly access: `http://localhost:8000/tutor/dashboard`

### Verify Features
- ✅ Dashboard loads successfully
- ✅ Statistics cards display correct data
- ✅ Quick action buttons are functional
- ✅ Upcoming classes section works
- ✅ Recent materials section works
- ✅ Responsive design on mobile
- ✅ Role-based access control

## Security Features

1. **Authentication Required**: All tutor routes require login
2. **Role Verification**: Only users with 'tutor' role can access
3. **Password Hashing**: Automatic password encryption via User model
4. **CSRF Protection**: All forms protected with CSRF tokens
5. **Session Management**: Laravel's built-in session security

## Future Enhancements

Potential features to add:
1. Real-time class monitoring
2. Student attendance tracking
3. Performance analytics
4. Interactive whiteboard for classes
5. Assignment grading system
6. Communication tools (chat, announcements)
7. Calendar integration
8. Material analytics (views, downloads)
9. Student feedback system
10. Automated report generation

## Troubleshooting

### Issue: Cannot Login
- Verify email and password
- Check if user has 'tutor' role assigned
- Clear browser cache and cookies
- Run: `php artisan cache:clear`

### Issue: 403 Forbidden
- Verify user has 'tutor' role
- Check middleware configuration
- Ensure role exists in database

### Issue: Dashboard Not Loading
- Check Laravel logs: `storage/logs/laravel.log`
- Verify database connection
- Run migrations: `php artisan migrate`

### Issue: Missing Role
- Run seeder: `php artisan db:seed --class=TutorSeeder`
- Or create role manually via tinker

## Support

For additional support or questions:
- Email: ukmbimbel@stis.ac.id
- Contact Person: (as listed in main application)

---

**Last Updated**: October 14, 2025
**Version**: 1.0.0
**Status**: Production Ready ✅