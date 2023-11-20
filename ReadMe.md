download the necessary tools:
https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.2.4/xampp-windows-x64-8.2.4-0-VS16-installer.exe
https://nodejs.org/dist/v18.17.1/node-v18.17.1-x64.msi
https://getcomposer.org/Composer-Setup.exe

NOTE: When install python, make sure to check the box that says: Add python 3.9 to PATH

https://www.python.org/ftp/python/3.9.13/python-3.9.13-amd64.exe
https://code.visualstudio.com/sha/download?build=stable&os=win32-x64-user




Open up Xampp
modify the php.ini
In the Apache section click Config -> PHP (php.ini)

Find and replace two lines:
;extension=gd
;extension=zip

enable it by removing the ; sign at the start

Open up vscode

Open the project folder Click File->Open Folder

Open terminal in vscode Ctrl+J, Select Command prompt(not powershell) Run the ff command (everytime there are code changes):

composer install
npm install

php artisan migrate --seed



Run the ff to start locally:

php artisan serve
npm run dev






pyinstaller --noconsole alert_production.py