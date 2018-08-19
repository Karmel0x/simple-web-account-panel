# simple-web-account-panel
Simple secure PHP web account panel - Defaultly written for MMORPG game LastChaos  
Main idea is to separate the server webcard from the panel and redirect to login,  
just place the main page on domain.com and panel on the domain.com/cabinet/

## Features
- Using PDO MySQL
- Structural oriented
```
Passwords are hashed with md5 as LC using but it's not the best practice
There is no limit of login attempts, it would be good to add a captcha or something
```

## Screenshots
- [Screenshot 1](https://raw.githubusercontent.com/Karmel0x/simple-web-account-panel/master/Screenshot1.jpg)
- [Screenshot 2](https://raw.githubusercontent.com/Karmel0x/simple-web-account-panel/master/Screenshot2.jpg)

## Configuration
- Edit the values in assets/config.php
- Edit page/donate.php application link for payment gateway
- Edit APP_SECRET_KEY in assets/pingbacklc_sr.php for SuperRewards payment gateway
- Edit APP_SECRET_KEY in assets/pingbacklc_pmw.php for Paymentwall payment gateway

## Donations
All donations are unnecessary and not expected, but greatly appreciated.

Bitcoin: 17SaMettdoMLnwJxQz4xy13PwrrUChp4aR
