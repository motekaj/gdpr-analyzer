### Readme

Live demo available [here](https://dpotool.cs.ut.ee)

Persistent folder for redployment:  `/web/uploads`

For local setup:

1. Download repo
2. Import database using template `/db.sql` in phpmyadmin
3. Configure db connection stored in `config/db.php` to connect application to database
4. run `composer install`
5. run `php yii serve`

More info: [Yii2 deployment guide](http://stuff.cebe.cc/yii2docs/guide-start-databases.html)