# WP Letter Automation Plugin

## 📋 Table of Contents

- [English Documentation](#english-documentation)
- [Persian Documentation](#persian-documentation-مستندات-فارسی)

---

## English Documentation

### Overview

**WP Letter Automation** is a powerful WordPress plugin designed to automate letter and document generation, management, and distribution within your WordPress environment. This plugin streamlines the process of creating, sending, and tracking automated correspondence for your website visitors, customers, and team members.

### ✨ Features

#### Core Features

- **Automated Letter Generation**: Automatically generate letters based on predefined templates
- **Template Management**: Create and manage multiple letter templates with custom variables
- **Bulk Operations**: Send letters in bulk to multiple recipients
- **Scheduled Delivery**: Schedule letters to be sent at specific dates and times
- **Variable Substitution**: Use dynamic variables (name, email, date, etc.) in templates
- **Email Integration**: Seamlessly integrate with WordPress email system
- **User Role Support**: Send letters to specific user roles or user IDs
- **Activity Logging**: Track all automated letter activities and delivery status
- **Conditional Logic**: Create conditional templates based on user data or custom fields
- **PDF Export**: Export generated letters to PDF format

#### Advanced Features

- **Custom Post Types**: Dedicated post types for letters and templates
- **Shortcodes**: Use shortcodes to display letter content on pages
- **REST API Support**: Programmatic access to letter automation functionality
- **Email Logs**: Detailed logs of all sent letters and delivery status
- **Retry Mechanism**: Automatic retry for failed letter deliveries
- **Rate Limiting**: Control the number of letters sent per hour
- **Custom CSS Support**: Style generated letters with custom CSS
- **Webhook Integration**: Send notifications to external services

### 📦 Installation

#### Requirements

- **WordPress**: Version 5.0 or higher
- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.6 or higher
- **Required Extensions**: json, mbstring, zip

#### Installation Steps

1. **Download the Plugin**
   ```bash
   git clone https://github.com/mahlachat-hue/wp-letter-automation.git wp-letter-automation
   ```

2. **Upload to WordPress**
   - Navigate to `/wp-content/plugins/` directory
   - Upload the `wp-letter-automation` folder

3. **Activate the Plugin**
   - Go to **WordPress Admin Dashboard**
   - Navigate to **Plugins** → **Installed Plugins**
   - Find **WP Letter Automation**
   - Click **Activate**

4. **Initial Setup**
   - A new menu item "Letter Automation" will appear in the sidebar
   - Go to **Letter Automation** → **Settings**
   - Configure basic settings as needed

### 🚀 Usage Guide

#### Creating a Letter Template

1. **Navigate to Templates**
   ```
   WordPress Admin → Letter Automation → Letter Templates
   ```

2. **Create New Template**
   - Click **Add New** button
   - Enter template title (e.g., "Welcome Letter")
   - Add template content with variables

3. **Available Variables**
   - `{first_name}` - User's first name
   - `{last_name}` - User's last name
   - `{user_email}` - User's email address
   - `{username}` - WordPress username
   - `{user_id}` - WordPress user ID
   - `{site_name}` - Your website name
   - `{current_date}` - Current date
   - `{current_time}` - Current time
   - `{custom_field_name}` - Custom user meta value

4. **Example Template**
   ```
   Dear {first_name} {last_name},
   
   Welcome to {site_name}! We're excited to have you on board.
   
   Your account details:
   - Username: {username}
   - Email: {user_email}
   
   Best regards,
   The {site_name} Team
   ```

5. **Save Template**
   - Click **Publish**

#### Sending Automated Letters

##### Method 1: Send to Specific User

1. Go to **Letter Automation** → **Send Letters**
2. Select recipients:
   - Choose specific users
   - Or select by user role (Subscribers, Customers, etc.)
3. Select letter template
4. Configure delivery options:
   - Send immediately
   - Schedule for later
   - Set custom sender name/email
5. Click **Send Now** or **Schedule**

##### Method 2: Using Shortcodes

Add letter content to pages or posts:

```php
[wp_letter_automation template="welcome-letter" user_id="current"]

[wp_letter_automation template="welcome-letter" user_role="subscriber"]

[wp_letter_automation template="welcome-letter" show_preview="true"]
```

##### Method 3: Programmatic Usage

```php
// Include the plugin
require_once(WP_PLUGIN_DIR . '/wp-letter-automation/includes/class-letter-sender.php');

// Initialize sender
$letter_sender = new WP_Letter_Automation_Sender();

// Send letter to user
$result = $letter_sender->send_letter(
    $template_id,
    $user_id,
    array(
        'custom_variables' => array(
            'special_offer' => '50% Off'
        ),
        'scheduled_time' => strtotime('+1 day'),
        'from_name' => 'Support Team',
        'from_email' => 'support@example.com'
    )
);

if ($result['success']) {
    echo "Letter sent successfully!";
} else {
    echo "Error: " . $result['message'];
}
```

### ⚙️ Configuration Settings

#### General Settings

Navigate to **Letter Automation** → **Settings** → **General**

| Setting | Description | Default |
|---------|-------------|---------|
| **From Name** | Default sender name | Site title |
| **From Email** | Default sender email | Admin email |
| **Enable Logging** | Log all letter activities | Enabled |
| **Log Retention Days** | Days to keep activity logs | 30 days |
| **Enable PDF Export** | Allow PDF generation | Enabled |
| **Rate Limit (per hour)** | Max letters sent per hour | 100 |

#### Email Settings

Navigate to **Letter Automation** → **Settings** → **Email**

| Setting | Description | Default |
|---------|-------------|---------|
| **SMTP Enabled** | Use custom SMTP server | Disabled |
| **SMTP Host** | SMTP server address | - |
| **SMTP Port** | SMTP port number | 587 |
| **SMTP User** | SMTP authentication username | - |
| **SMTP Password** | SMTP authentication password | - |
| **SMTP Encryption** | TLS or SSL | TLS |

#### Template Settings

Navigate to **Letter Automation** → **Settings** → **Templates**

| Setting | Description | Default |
|---------|-------------|---------|
| **Default Template Style** | CSS for template rendering | Default |
| **Include Header** | Show header in generated letters | Enabled |
| **Include Footer** | Show footer in generated letters | Enabled |
| **Custom CSS** | Additional custom styles | - |

### 📊 Activity Logs

Monitor and manage letter activities:

1. **Access Activity Logs**
   ```
   WordPress Admin → Letter Automation → Activity Logs
   ```

2. **Log Information Includes**
   - Sender and recipient details
   - Template used
   - Delivery status (Sent, Failed, Pending, etc.)
   - Sent date and time
   - Retry attempts
   - Error messages (if any)

3. **Filter and Search**
   - Filter by status
   - Search by recipient email
   - Sort by date range
   - Export logs to CSV

### 🔌 API Reference

#### REST API Endpoints

##### Get Templates
```
GET /wp-json/wp-letter-automation/v1/templates
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 123,
      "title": "Welcome Letter",
      "content": "...",
      "variables": ["first_name", "last_name"]
    }
  ]
}
```

##### Send Letter
```
POST /wp-json/wp-letter-automation/v1/send
```

**Request Body:**
```json
{
  "template_id": 123,
  "user_id": 456,
  "scheduled_time": "2025-12-24 10:00:00",
  "custom_variables": {
    "custom_field": "value"
  }
}
```

##### Get Logs
```
GET /wp-json/wp-letter-automation/v1/logs?user_id=456&status=sent
```

### 🔒 Security Features

- **Nonce Verification**: All forms protected with WordPress nonces
- **Capability Checking**: Role-based access control
- **SQL Injection Prevention**: Prepared statements for all database queries
- **XSS Protection**: Proper escaping of all output
- **Data Sanitization**: Input validation and sanitization
- **Rate Limiting**: Prevent abuse through rate limiting
- **Audit Logging**: Complete audit trail of all activities

### 📝 Shortcode Reference

#### Display Letter Content

```php
[wp_letter_automation 
    template="template-slug"
    user_id="current"
    show_preview="true"
    display_format="html"
]
```

**Attributes:**
- `template` (required): Template name or ID
- `user_id`: User ID or "current" for logged-in user
- `show_preview`: Display preview without sending
- `display_format`: "html" or "text"

#### Letter Template Loop

```php
[wp_letter_loop 
    template="template-slug"
    user_role="subscriber"
    limit="10"
]
    Content to display for each letter...
[/wp_letter_loop]
```

### 🐛 Troubleshooting

#### Letters Not Sending

1. **Check Plugin Settings**
   - Verify sender email configuration
   - Check SMTP settings if using custom mail server
   - Ensure email addresses are valid

2. **Review Activity Logs**
   - Check for error messages
   - Look for failed delivery attempts
   - Review retry status

3. **Verify Templates**
   - Ensure template exists and is published
   - Check template variables are correct
   - Validate email content

#### Performance Issues

1. **Optimize Settings**
   - Reduce rate limit if server is overwhelmed
   - Enable logging cleanup (auto-delete old logs)
   - Use scheduled deliveries instead of immediate sends

2. **Database Optimization**
   - Run WordPress database optimization
   - Archive old activity logs
   - Clean up failed delivery attempts

### 📚 Examples

#### Example 1: New User Welcome Letter

```php
Template Content:
---
Subject: Welcome to {site_name}

Dear {first_name},

Thank you for joining {site_name}! Your account has been created successfully.

Account Information:
- Username: {username}
- Email: {user_email}
- Join Date: {current_date}

Next Steps:
1. Complete your profile
2. Explore our features
3. Connect with the community

Best regards,
The {site_name} Team
```

#### Example 2: Order Confirmation Letter

```php
Template with Conditional Logic:
---
Dear {first_name},

Thank you for your order! Your order confirmation details:

Order Information:
- Order ID: {order_id}
- Total Amount: {order_total}
- Status: {order_status}

[if {order_status} == pending]
We'll notify you once your order ships.
[/if]

[if {order_status} == completed]
Your order has been dispatched!
[/if]

Thank you for shopping with us!
```

#### Example 3: Scheduled Bulk Mailing

```php
// Send newsletter to all subscribers next Monday at 9 AM
$letter_sender = new WP_Letter_Automation_Sender();

$next_monday = strtotime('next Monday 09:00:00');

$result = $letter_sender->send_bulk_letter(
    $template_id,
    array(
        'role' => 'subscriber'
    ),
    array(
        'scheduled_time' => $next_monday,
        'track_opens' => true,
        'track_clicks' => true
    )
);
```

### 🤝 Contributing

We welcome contributions! Here's how you can help:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### 📄 License

This plugin is released under the GPL v2 or later. See the LICENSE file for more details.

### 💬 Support

For support and questions:

- **GitHub Issues**: [Report bugs or request features](https://github.com/mahlachat-hue/wp-letter-automation/issues)
- **Documentation**: [Full documentation](https://github.com/mahlachat-hue/wp-letter-automation/wiki)
- **Email**: [Contact support](mailto:support@example.com)

### 📈 Changelog

#### Version 1.0.0 (2025-12-23)
- Initial release
- Core letter automation features
- Template management system
- Activity logging
- REST API support
- Email integration

---

---

## Persian Documentation (مستندات فارسی)

### نمای کلی

**WP Letter Automation** یک افزونه قدرتمند وردپرس است که برای خودکارسازی تولید، مدیریت و توزیع نامه‌ها و اسناد در محیط وردپرس طراحی شده است. این افزونه فرآیند ایجاد، ارسال و ردیابی مکاتبات خودکار برای بازدیدکنندگان وب‌سایت، مشتریان و اعضای تیم شما را ساده می‌کند.

### ✨ ویژگی‌ها

#### ویژگی‌های اصلی

- **تولید خودکار نامه**: تولید خودکار نامه‌ها بر اساس الگوهای از پیش تعیین شده
- **مدیریت الگو**: ایجاد و مدیریت الگوهای متعدد با متغیرهای سفارشی
- **عملیات انبوه**: ارسال نامه‌ها به صورت انبوه به چندین گیرنده
- **برنامه‌ریزی ارسال**: برنامه‌ریزی ارسال نامه‌ها در تاریخ و زمان‌های خاص
- **جایگزینی متغیرها**: استفاده از متغیرهای پویا (نام، ایمیل، تاریخ، و غیره) در الگوها
- **یکپارچگی ایمیل**: ادغام یکپارچه با سیستم ایمیل وردپرس
- **پشتیبانی نقش کاربر**: ارسال نامه‌ها به نقش‌های خاص یا شناسه‌های کاربری
- **ثبت فعالیت**: ردیابی تمام فعالیت‌های نامه‌های خودکار و وضعیت تحویل
- **منطق شرطی**: ایجاد الگوهای شرطی بر اساس داده‌های کاربر یا فیلدهای سفارشی
- **صادرات PDF**: صادرات نامه‌های تولید شده به فرمت PDF

#### ویژگی‌های پیشرفته

- **انواع پست سفارشی**: انواع پست اختصاصی برای نامه‌ها و الگوها
- **کدهای کوتاه**: استفاده از کدهای کوتاه برای نمایش محتوای نامه در صفحات
- **پشتیبانی REST API**: دسترسی برنامه‌ای به عملکرد خودکارسازی نامه
- **ثبت ایمیل**: ثبت تفصیلی تمام نامه‌های ارسال شده و وضعیت تحویل
- **مکانیزم تلاش مجدد**: تلاش خودکار مجدد برای تحویل نامه‌های ناموفق
- **محدود کردن نرخ**: کنترل تعداد نامه‌های ارسال شده در ساعت
- **پشتیبانی CSS سفارشی**: طراحی نامه‌های تولید شده با CSS سفارشی
- **یکپارچگی Webhook**: ارسال اطلاعات به سرویس‌های خارجی

### 📦 نصب

#### الزامات

- **وردپرس**: نسخه 5.0 یا بالاتر
- **PHP**: نسخه 7.4 یا بالاتر
- **MySQL**: نسخه 5.6 یا بالاتر
- **افزونه‌های مورد نیاز**: json، mbstring، zip

#### مراحل نصب

1. **دانلود افزونه**
   ```bash
   git clone https://github.com/mahlachat-hue/wp-letter-automation.git wp-letter-automation
   ```

2. **آپلود به وردپرس**
   - به دایرکتوری `/wp-content/plugins/` بروید
   - پوشه `wp-letter-automation` را آپلود کنید

3. **فعال کردن افزونه**
   - به **داشبورد مدیریت وردپرس** بروید
   - به **افزونه‌ها** → **افزونه‌های نصب شده** بروید
   - **WP Letter Automation** را پیدا کنید
   - روی **فعال کردن** کلیک کنید

4. **تنظیم اولیه**
   - یک مورد منو جدید "خودکارسازی نامه" در نوار کناری ظاهر می‌شود
   - به **خودکارسازی نامه** → **تنظیمات** بروید
   - تنظیمات اساسی را حسب نیاز پیکربندی کنید

### 🚀 راهنمای استفاده

#### ایجاد الگوی نامه

1. **رفتن به الگوها**
   ```
   داشبورد وردپرس → خودکارسازی نامه → الگوهای نامه
   ```

2. **ایجاد الگوی جدید**
   - دکمه **افزودن جدید** را کلیک کنید
   - عنوان الگو را وارد کنید (مثلا "نامه خوش‌آمدگویی")
   - محتوای الگو را با متغیرها اضافه کنید

3. **متغیرهای موجود**
   - `{first_name}` - نام کاربر
   - `{last_name}` - نام خانوادگی کاربر
   - `{user_email}` - آدرس ایمیل کاربر
   - `{username}` - نام کاربری وردپرس
   - `{user_id}` - شناسه کاربر وردپرس
   - `{site_name}` - نام وب‌سایت
   - `{current_date}` - تاریخ جاری
   - `{current_time}` - ساعت جاری
   - `{custom_field_name}` - مقدار متا کاربر سفارشی

4. **مثال از الگو**
   ```
   سلام {first_name} {last_name}!
   
   خوش‌آمدید به {site_name}! ما از داشتن شما خرسندیم.
   
   جزئیات حساب شما:
   - نام کاربری: {username}
   - ایمیل: {user_email}
   
   با احترام،
   تیم {site_name}
   ```

5. **ذخیره الگو**
   - روی **انتشار** کلیک کنید

#### ارسال نامه‌های خودکار

##### روش 1: ارسال به کاربر خاص

1. به **خودکارسازی نامه** → **ارسال نامه‌ها** بروید
2. انتخاب دریافت‌کنندگان:
   - کاربران خاص را انتخاب کنید
   - یا با نقش کاربر انتخاب کنید (اشتراک‌کنندگان، مشتریان، و غیره)
3. الگوی نامه را انتخاب کنید
4. گزینه‌های تحویل را پیکربندی کنید:
   - ارسال فوری
   - برنامه‌ریزی برای بعد
   - تنظیم نام/ایمیل فرستنده سفارشی
5. روی **ارسال الآن** یا **برنامه‌ریزی** کلیک کنید

##### روش 2: استفاده از کدهای کوتاه

اضافه کردن محتوای نامه به صفحات یا نوشته‌ها:

```php
[wp_letter_automation template="welcome-letter" user_id="current"]

[wp_letter_automation template="welcome-letter" user_role="subscriber"]

[wp_letter_automation template="welcome-letter" show_preview="true"]
```

##### روش 3: استفاده برنامه‌ای

```php
// شامل کردن افزونه
require_once(WP_PLUGIN_DIR . '/wp-letter-automation/includes/class-letter-sender.php');

// شروع ارسال‌کننده
$letter_sender = new WP_Letter_Automation_Sender();

// ارسال نامه به کاربر
$result = $letter_sender->send_letter(
    $template_id,
    $user_id,
    array(
        'custom_variables' => array(
            'special_offer' => '50% تخفیف'
        ),
        'scheduled_time' => strtotime('+1 day'),
        'from_name' => 'تیم پشتیبانی',
        'from_email' => 'support@example.com'
    )
);

if ($result['success']) {
    echo "نامه با موفقیت ارسال شد!";
} else {
    echo "خطا: " . $result['message'];
}
```

### ⚙️ تنظیمات پیکربندی

#### تنظیمات عمومی

به **خودکارسازی نامه** → **تنظیمات** → **عمومی** بروید

| تنظیم | توضیح | پیش‌فرض |
|-------|-------|--------|
| **نام فرستنده** | نام فرستنده پیش‌فرض | عنوان سایت |
| **ایمیل فرستنده** | ایمیل فرستنده پیش‌فرض | ایمیل مدیر |
| **فعال‌سازی ثبت** | ثبت تمام فعالیت‌های نامه | فعال |
| **روزهای نگهداری ثبت** | روزهای نگهداری تاریخچه فعالیت | 30 روز |
| **فعال‌سازی صادرات PDF** | اجازه تولید PDF | فعال |
| **محدودیت نرخ (در ساعت)** | حداکثر نامه‌های ارسال شده در ساعت | 100 |

#### تنظیمات ایمیل

به **خودکارسازی نامه** → **تنظیمات** → **ایمیل** بروید

| تنظیم | توضیح | پیش‌فرض |
|-------|-------|--------|
| **فعال‌سازی SMTP** | استفاده از سرور SMTP سفارشی | غیرفعال |
| **میزبان SMTP** | آدرس سرور SMTP | - |
| **درگاه SMTP** | شماره درگاه SMTP | 587 |
| **نام کاربری SMTP** | نام کاربری احراز هویت SMTP | - |
| **رمز عبور SMTP** | رمز عبور احراز هویت SMTP | - |
| **رمزگذاری SMTP** | TLS یا SSL | TLS |

#### تنظیمات الگو

به **خودکارسازی نامه** → **تنظیمات** → **الگوها** بروید

| تنظیم | توضیح | پیش‌فرض |
|-------|-------|--------|
| **سبک الگوی پیش‌فرض** | CSS برای رندر الگو | پیش‌فرض |
| **شامل کردن سرصفحه** | نمایش سرصفحه در نامه‌های تولید شده | فعال |
| **شامل کردن پاورقی** | نمایش پاورقی در نامه‌های تولید شده | فعال |
| **CSS سفارشی** | سبک‌های اضافی | - |

### 📊 تاریخچه فعالیت

مراقبت و مدیریت فعالیت‌های نامه:

1. **دسترسی به تاریخچه فعالیت**
   ```
   داشبورد وردپرس → خودکارسازی نامه → تاریخچه فعالیت
   ```

2. **اطلاعات موجود در تاریخچه**
   - جزئیات فرستنده و دریافت‌کننده
   - الگوی استفاده شده
   - وضعیت تحویل (ارسال شد، ناموفق، معلق، و غیره)
   - تاریخ و ساعت ارسال
   - تعداد تلاش‌های مجدد
   - پیام‌های خطا (در صورت وجود)

3. **فیلتر و جستجو**
   - فیلتر براساس وضعیت
   - جستجو براساس ایمیل دریافت‌کننده
   - مرتب‌سازی براساس محدوده تاریخی
   - صادرات تاریخچه به CSV

### 🔌 مرجع API

#### نقاط پایانی REST API

##### دریافت الگوها
```
GET /wp-json/wp-letter-automation/v1/templates
```

**پاسخ:**
```json
{
  "success": true,
  "data": [
    {
      "id": 123,
      "title": "نامه خوش‌آمدگویی",
      "content": "...",
      "variables": ["first_name", "last_name"]
    }
  ]
}
```

##### ارسال نامه
```
POST /wp-json/wp-letter-automation/v1/send
```

**بدنه درخواست:**
```json
{
  "template_id": 123,
  "user_id": 456,
  "scheduled_time": "2025-12-24 10:00:00",
  "custom_variables": {
    "custom_field": "مقدار"
  }
}
```

##### دریافت تاریخچه
```
GET /wp-json/wp-letter-automation/v1/logs?user_id=456&status=sent
```

### 🔒 ویژگی‌های امنیتی

- **تایید Nonce**: حفاظت تمام فرم‌ها با nonce‌های وردپرس
- **بررسی توانایی**: کنترل دسترسی مبتنی بر نقش
- **جلوگیری از تزریق SQL**: استفاده از دستورات آماده شده برای تمام درخواست‌های پایگاه داده
- **حفاظت از XSS**: فرار مناسب تمام خروجی‌ها
- **تصحیح داده‌ها**: تایید و تصحیح ورودی
- **محدود کردن نرخ**: جلوگیری از سوء استفاده از طریق محدود کردن نرخ
- **ثبت بازرسی**: مسیر بازرسی کامل تمام فعالیت‌ها

### 📝 مرجع کدهای کوتاه

#### نمایش محتوای نامه

```php
[wp_letter_automation 
    template="template-slug"
    user_id="current"
    show_preview="true"
    display_format="html"
]
```

**صفات:**
- `template` (ضروری): نام یا شناسه الگو
- `user_id`: شناسه کاربر یا "current" برای کاربر وارد شده
- `show_preview`: نمایش پیش‌نمایش بدون ارسال
- `display_format`: "html" یا "text"

#### حلقه الگوی نامه

```php
[wp_letter_loop 
    template="template-slug"
    user_role="subscriber"
    limit="10"
]
    محتوای نمایش برای هر نامه...
[/wp_letter_loop]
```

### 🐛 حل مشکلات

#### نامه‌ها ارسال نمی‌شوند

1. **بررسی تنظیمات افزونه**
   - تایید پیکربندی ایمیل فرستنده
   - بررسی تنظیمات SMTP در صورت استفاده از سرور ایمیل سفارشی
   - اطمینان از معتبر بودن آدرس‌های ایمیل

2. **بررسی تاریخچه فعالیت**
   - جستجو برای پیام‌های خطا
   - بررسی تلاش‌های ناموفق تحویل
   - بررسی وضعیت تلاش مجدد

3. **تایید الگوها**
   - اطمینان از وجود و انتشار الگو
   - بررسی صحت متغیرهای الگو
   - تایید محتوای ایمیل

#### مشکلات عملکرد

1. **بهینه‌سازی تنظیمات**
   - کاهش محدودیت نرخ در صورت بارگذاری سرور
   - فعال‌سازی پاک‌سازی خودکار تاریخچه
   - استفاده از برنامه‌ریزی ارسال به جای ارسال فوری

2. **بهینه‌سازی پایگاه داده**
   - اجرای بهینه‌سازی پایگاه داده وردپرس
   - آرشیو کردن تاریخچه قدیمی
   - پاک‌سازی تلاش‌های ناموفق

### 📚 نمونه‌ها

#### نمونه 1: نامه خوش‌آمدگویی کاربر جدید

```php
محتوای الگو:
---
موضوع: خوش‌آمدید به {site_name}

سلام {first_name}!

متشکرم از پیوستن به {site_name}! حساب شما با موفقیت ایجاد شده است.

اطلاعات حساب:
- نام کاربری: {username}
- ایمیل: {user_email}
- تاریخ عضویت: {current_date}

مراحل بعدی:
1. تکمیل نمایه شما
2. بررسی ویژگی‌های ما
3. اتصال به جامعه

با احترام،
تیم {site_name}
```

#### نمونه 2: نامه تایید سفارش

```php
الگو با منطق شرطی:
---
سلام {first_name}!

متشکرم از سفارش شما! جزئیات تأیید سفارش شما:

اطلاعات سفارش:
- شناسه سفارش: {order_id}
- مبلغ کل: {order_total}
- وضعیت: {order_status}

[if {order_status} == pending]
ما پس از ارسال سفارش شما را مطلع خواهیم کرد.
[/if]

[if {order_status} == completed]
سفارش شما برای ارسال آماده است!
[/if]

متشکریم از خریداری شما!
```

#### نمونه 3: ارسال انبوه برنامه‌ریزی شده

```php
// ارسال خبرنامه به تمام اشتراک‌کنندگان دوشنبه ساعت 9 صبح
$letter_sender = new WP_Letter_Automation_Sender();

$next_monday = strtotime('next Monday 09:00:00');

$result = $letter_sender->send_bulk_letter(
    $template_id,
    array(
        'role' => 'subscriber'
    ),
    array(
        'scheduled_time' => $next_monday,
        'track_opens' => true,
        'track_clicks' => true
    )
);
```

### 🤝 مشارکت

ما به مشارکت‌های شما استقبال می‌کنیم! اینجا نحوه کمک شما است:

1. Fork مخزن را انجام دهید
2. یک شاخه ویژگی ایجاد کنید (`git checkout -b feature/amazing-feature`)
3. تغییرات خود را commit کنید (`git commit -m 'Add amazing feature'`)
4. به شاخه push کنید (`git push origin feature/amazing-feature`)
5. یک Pull Request باز کنید

### 📄 مجوز

این افزونه تحت مجوز GPL v2 یا بالاتر منتشر شده است. برای جزئیات بیشتر به فایل LICENSE مراجعه کنید.

### 💬 پشتیبانی

برای پشتیبانی و سؤالات:

- **GitHub Issues**: [گزارش باگ یا درخواست ویژگی](https://github.com/mahlachat-hue/wp-letter-automation/issues)
- **Documentation**: [مستندات کامل](https://github.com/mahlachat-hue/wp-letter-automation/wiki)
- **Email**: [تماس با پشتیبانی](mailto:support@example.com)

### 📈 تاریخچه نسخه‌ها

#### نسخه 1.0.0 (2025-12-23)
- انتشار اولیه
- ویژگی‌های اصلی خودکارسازی نامه
- سیستم مدیریت الگو
- ثبت فعالیت
- پشتیبانی REST API
- یکپارچگی ایمیل

---

**آخرین به‌روزرسانی:** 2025-12-23
**نسخه:** 1.0.0

**تماس و پشتیبانی:**
- 📧 ایمیل: support@example.com
- 🌐 وب‌سایت: https://example.com
- 🐙 GitHub: https://github.com/mahlachat-hue/wp-letter-automation
