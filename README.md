# VATINFO-API

A not-proud-of-making-it-like-this api foy me [VATINFO](https://github.com/e4rthdog/vatinfo) app.

## Installation

---

-   Clone the repo.
-   Run `composer install`
-   Copy the `vatinfo-panels-config-example.php` file to `vatinfo-panels-config.php` and _**update**_ the file with your actual access and database information.
-   Create the MySQL database by importing the file `vatinfo-database.sql`
-   Serve the directory

## Libraries Used

---

-   [VATSIMPHP](https://github.com/skymeyer/Vatsimphp). Most of the data are proxied from official VATSIM data using this library.

## Files aka "endpoints" :)

---

### **getdata.php:**

Will get you most of the data from VATSIM. It expects a `type` querystring parameter that can be one of the following: `ALL` , `ATC` , `PILOT` , `INFO`, `SERVERS`, `CALLSIGN` , `CID` , `METAR`

`CID` and `METAR` require additionally a `q=` querystring representing the `CID` or `ICAO` respectively.

_Examples:_

> https://YOUR-SERVER-PATH/getdata.php?type=ATC

> https://YOUR-SERVER-PATH/getdata.php?type=METAR&q=LGAV

### **getevents.php:**

Proxy for the official VATSIM event list.

_Examples:_

> https://YOUR-SERVER-PATH/getevents.php

### **getmetar.php:**

Proxy for the official VATSIM METAR endpoint.

_Examples:_

> https://YOUR-SERVER-PATH/getevents.php
