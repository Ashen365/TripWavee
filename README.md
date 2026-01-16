# 🌊 TripWave - Sri Lanka Tourism Platform

TripWave is a comprehensive web-based tourism platform designed to help travelers explore and experience the beauty of Sri Lanka. Discover tours, hotels, restaurants, and activities across the island.

## 🌟 Features

- **Tours & Activities**: Browse and book guided tours and exciting activities
- **Hotel Booking**: Find and reserve accommodations across Sri Lanka
- **Restaurant Discovery**: Explore local dining options with ratings and reviews
- **User Authentication**: Secure registration and login system
- **Personal Itinerary**: Manage all your bookings in one place
- **Community Forum**: Connect with other travelers and share experiences
- **Search & Filter**: Easy-to-use search functionality for all categories
- **Responsive Design**: Mobile-friendly interface built with Materialize CSS

## 🛠️ Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript, Materialize CSS
- **Backend**: PHP 7+
- **Database**: MySQL
- **Server**: Apache (XAMPP)
- **Icons**: Font Awesome 6

## 📋 Prerequisites

- XAMPP (or any PHP/MySQL environment)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser (Chrome, Firefox, Edge, etc.)

## 🚀 Installation & Setup

### 1. Clone the Repository
```bash
git clone https://github.com/Ashen365/TripWavee.git
cd TripWavee
```

### 2. Move to XAMPP Directory
Copy the project folder to your XAMPP htdocs directory:
```
C:\xampp\htdocs\Tripwave
```

### 3. Start XAMPP Services
- Open XAMPP Control Panel
- Start **Apache** and **MySQL**

### 4. Setup Database
1. Open phpMyAdmin: http://localhost/phpmyadmin
2. Click on **Import** tab
3. Choose the `database.sql` file from the project
4. Click **Go** to import

### 5. Access the Application
Open your browser and navigate to:
```
http://localhost/Tripwave
```

## 📁 Project Structure

```
Tripwave/
├── assets/
│   ├── css/          # Stylesheets
│   ├── images/       # Images and media files
│   └── js/           # JavaScript files
├── includes/
│   ├── db.php        # Database connection
│   ├── header.php    # Common header
│   └── footer.php    # Common footer
├── pages/
│   ├── login.php     # User login
│   ├── register.php  # User registration
│   ├── tours.php     # Tour listings
│   ├── hotels.php    # Hotel listings
│   ├── restaurants.php # Restaurant listings
│   ├── activities.php # Activity listings
│   ├── booking.php   # Booking management
│   ├── itinerary.php # User itinerary
│   └── community.php # Community forum
├── index.php         # Homepage
├── database.sql      # Database schema
└── README.md         # Project documentation
```

## 🗄️ Database Schema

The application uses 7 main tables:

- **users** - User accounts and profiles
- **tours** - Tour packages and information
- **hotels** - Hotel listings and details
- **restaurants** - Restaurant information
- **activities** - Activity listings
- **booking** - User bookings across all categories
- **community_posts** - User-generated community content

## 🔐 Default Configuration

Database configuration in `includes/db.php`:
- Host: `localhost`
- Username: `root`
- Password: `` (empty)
- Database: `tripwaveeeeeeee`

## 🎯 Usage

1. **Register** - Create a new account
2. **Login** - Access your account
3. **Browse** - Explore tours, hotels, restaurants, and activities
4. **Book** - Reserve your preferred services
5. **Manage** - View and organize your bookings in the itinerary
6. **Connect** - Share experiences in the community forum

## 🌐 Future Enhancements

- [ ] Payment gateway integration
- [ ] Email notifications
- [ ] Reviews and ratings system
- [ ] Advanced search filters
- [ ] Admin dashboard
- [ ] Multi-language support
- [ ] Mobile application
- [ ] Social media integration

## 👥 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

## 👨‍💻 Developer

**Ashen365**
- GitHub: [@Ashen365](https://github.com/Ashen365)

## 🙏 Acknowledgments

- Materialize CSS for the responsive framework
- Font Awesome for icons
- The Sri Lankan tourism community

---

**Made with ❤️ for Sri Lanka Tourism**