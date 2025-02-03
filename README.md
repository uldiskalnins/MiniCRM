Jā, protams! Šeit ir abi teksti, formatēti GitHub README formātā:

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

2.  Šajā pašā failā norādiet, ka sistēma darbosies izstrādes režīmā, jo tas atvieglos kļūdu izķeršanu.
    Piemērs:

    ```
    CI_ENVIRONMENT = development
    ```

    Kad sistēma tiks nodota pilnvērtīgai darbība šo parametru ir jānomaina uz:

    ```
    CI_ENVIRONMENT = production
    ```

3.  Lai palaistu sistēmu ar PHP iebūvēto web serveri, komandrindā pārejiet uz sistēmas saknes direktoriju un izpildiet komandu:

    ```
    php spark serve
    ```

    un tad pārlūkā atveriet: `http://localhost:8080/`

---

## MiniCRM (English)

MiniCRM is a CRM system built on the Codeigniter4 (4.4) framework for self-employed individuals and small businesses. The system requires PHP 7.4+ and Mysql (5.1+) or MariaDB.
PHP must have the intl and mbstring extensions enabled.

### Installation

Before the first launch, you must first make some changes to the configuration files.

1.  Rename the `env` file in the system root to `.env` and uncomment the configuration section responsible for the database and enter your database details.
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

2.  In the same file, specify that the system will operate in development mode, as this will make it easier to catch errors.
    Example:

    ```
    CI_ENVIRONMENT = development
    ```

    When the system is put into production, this parameter must be changed to:

    ```
    CI_ENVIRONMENT = production
    ```

3.  To run the system with the built-in PHP web server, go to the system root directory in the command line and execute the command:

    ```
    php spark serve
    ```

    and then open in your browser: `http://localhost:8080/`

Kā redzams, esmu izmantojis Markdown sintaksi, lai formatētu tekstu virsrakstos, koda blokos un citos elementos, kas ir piemērots GitHub README failiem.
