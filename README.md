
## MiniCRM

MiniCRM ir uz Codeigniter4 (4.4) ietvara bāzes veidota CRM sistēma pašnodarbinātajiem un nelieliem uzņēmumiem. Sistēmas darbībai ir nepieciešams PHP 7.4+ un Mysql (5.1+) vai MariaDB.
PHP ir jābūt iespējotiem intl un mbstring paplašinājumiem.

### Uzstādīšana

Pirms pirmās palaišanas vispirms ir jāveic dažas izmaiņas konfigurācijas failos.

1.  Pārdēvējiet sistēmas saknē esošo `env` failu par `.env` un atkomentējiet tajā konfigurācijas daļu, kas atbild par datubāzi un norādiet tajā savas datubāzes datus.
    Piemērs:

    ```
    database.default.hostname = localhost
    database.default.database = ci4
    database.default.username = root
    database.default.password = root
    database.default.DBDriver = MySQLi
    database.default.DBPrefix =
    database.default.port = 3306
    ```

2.  Lai atvieglotu kļūdu izķeršanu sistēma pēc noklusējuma darbosies izstrādes režīmā

    Kad sistēma tiks nodota pilnvērtīgai darbība, būs jāatkomentē šis uzstādījums:

    ```
    CI_ENVIRONMENT = production
    ```

3.  Lai palaistu sistēmu ar PHP iebūvēto web serveri, komandrindā pārejiet uz sistēmas saknes direktoriju un izpildiet komandu:

    ```
    php spark serve
    ```

    un tad pārlūkā atveriet: `http://localhost:8080/`
    

 4. Lai darbinātu sistēmu uz cita servera būs jāmaina arī `/app/Config/App.php` faila mainīgais:
 
    ```
    public string $baseURL = 'http://localhost:8080/';  //jāizmaina uz jums nepieciešamo
    ```


---

## MiniCRM

MiniCRM is a CRM system built on the Codeigniter4 (4.4) framework, designed for self-employed individuals and small businesses. The system requires PHP 7.4+ and MySQL (5.1+) or MariaDB. The PHP extensions `intl` and `mbstring` must be enabled.

### Installation

Before the first launch, you need to make some changes in the configuration files.

1. Rename the `env` file located in the system's root directory to `.env`, uncomment the database configuration section, and enter your database details.
   Example:

   ```
   database.default.hostname = localhost
   database.default.database = ci4
   database.default.username = root
   database.default.password = root
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = 3306
   ```

2. To make it easier to catch errors, the system will run in development mode by default.

   When the system is ready for production, you will need to uncomment this setting:

   ```
   CI_ENVIRONMENT = production
   ```

3. To run the system with the built-in PHP web server, go to the system's root directory in the command line and execute the command:

   ```
   php spark serve
   ```

   Then open `http://localhost:8080/` in your browser.

4. To run the system on a different server, you will also need to change the `baseURL` variable in the `/app/Config/App.php` file:

   ```
   public string $baseURL = 'http://localhost:8080/'; // Change to your required URL
   ```
