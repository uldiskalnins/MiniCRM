## MiniCRM

MiniCRM ir uz CodeIgniter 4 (4.4.8) ietvara bāzes veidota CRM sistēma pašnodarbinātajiem un nelieliem uzņēmumiem. Sistēmas darbībai ir nepieciešams PHP 7.4+ un MySQL (5.1+) vai MariaDB.  
PHP ir jābūt iespējotiem `intl`, `mbstring` un `json` paplašinājumiem.  

![MiniCRM](https://i.imgur.com/z3PCceJ.jpg)  

### Uzstādīšana  

Pirms pirmās palaišanas vispirms ir jāveic dažas izmaiņas konfigurācijas failos.  

1. **Instalējiet atkarības, izpildot komandu sistēmas saknes direktorijā:**  

   ```sh
   composer install
   ```

2. **Pārdēvējiet sistēmas saknē esošo `env` failu par `.env`, atkomentējiet konfigurācijas daļu, kas atbild par noklusēto datubāzi, un norādiet tajā savus datubāzes datus.**  
   Piemērs:  

   ```ini
   database.default.hostname = localhost
   database.default.database = ci4
   database.default.username = root
   database.default.password = root
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = 3306
   ```

3. **Šajā pašā failā norādiet, ka sistēma darbosies izstrādes režīmā, jo tas atvieglos kļūdu izķeršanu.**  

   ```ini
   CI_ENVIRONMENT = development
   ```

   Kad sistēma tiks nodota pilnvērtīgai darbībai, šis uzstādījums ir jānomaina uz:  

   ```ini
   CI_ENVIRONMENT = production
   ```

4. **Lai palaistu sistēmu ar PHP iebūvēto web serveri, komandrindā pārejiet uz sistēmas saknes direktoriju un izpildiet komandu:**  

   ```sh
   php spark serve
   ```

   Pēc tam pārlūkā atveriet: `http://localhost:8080/`

5. **Lai darbinātu sistēmu uz cita servera, būs jāmaina `/app/Config/App.php` faila mainīgais:**  

   ```php
   public string $baseURL = 'http://localhost:8080/';  // Jāizmaina uz nepieciešamo URL
   ```

---

## MiniCRM

MiniCRM is a CRM system built on the CodeIgniter 4 (4.4.8) framework, designed for self-employed individuals and small businesses. The system requires PHP 7.4+ and MySQL (5.1+) or MariaDB.  
The PHP extensions `intl`, `mbstring`, and `json` must be enabled.  

### Installation  

Before the first launch, you need to make some changes in the configuration files.  

1. **Install dependencies by running the following command in the system's root directory:**  

   ```sh
   composer install
   ```

2. **Rename the `env` file located in the system's root directory to `.env`, uncomment the database configuration section, and enter your database details.**  
   Example:  

   ```ini
   database.default.hostname = localhost
   database.default.database = ci4
   database.default.username = root
   database.default.password = root
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = 3306
   ```

3. **In the same file, specify that the system will run in development mode, as this will make debugging easier.**  

   ```ini
   CI_ENVIRONMENT = development
   ```

   When the system is ready for production, this setting should be changed to:  

   ```ini
   CI_ENVIRONMENT = production
   ```

4. **To run the system with the built-in PHP web server, go to the system's root directory in the command line and execute the command:**  

   ```sh
   php spark serve
   ```

   Then open `http://localhost:8080/` in your browser.  

5. **To run the system on a different server, you will also need to change the `baseURL` variable in the `/app/Config/App.php` file:**  

   ```php
   public string $baseURL = 'http://localhost:8080/'; // Change to your required URL
   ```
