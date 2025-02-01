

MiniCRM

MiniCRM ir uz Codeigniter4(4.4) ietvara bāzes veidota CRM sistēma pašnodarbinātajiem un nelieliem uzņēmumiem.
Sistēmas darbībai ir nepieciešams PHP 7.4+ un Mysql(5.1+) vai MariaDB. <br/>
PHP ir jābūt iespējotiem intl un mbstring paplašinājumiem.

Pirms pirmās palaišanas vispirms ir jāveic dažas izmaiņas konfigurācijas failos.

Vispirms pārdēvējiet sistēmas saknē esošo env failu par .env un atkomentējiet tajā konfigurācijas daļu, kas atbild par datubāzi un norādiet tajā savas datubāzes datus. 

Piemērs:<br/>
database.default.hostname = localhost<br/>
database.default.database = ci4<br/>
database.default.username = root<br/>
database.default.password = root<br/>
database.default.DBDriver = MySQLi<br/>
database.default.DBPrefix =<br/>
database.default.port = 3306<br/>


Šajā pašā failā norādiet, ka sistēma darbosies izstrādes režīmā, jo tas atvieglos kļūdu izķeršanu. 

Piemērs:<br/>
CI_ENVIRONMENT = development<br/>

Kad sistēma tiks nodota pilnvērtīgai darbība šo parametru ir jānomaina uz: CI_ENVIRONMENT = production 

Lai palaistu sistēmu ar PHP iebūvēto web serveri, komandrindā pārejiet uz sistēmas saknes direktoriju un izpildiet komandu:
php spark serve  un tad pārlūkā atveriet: http://localhost:8080/










