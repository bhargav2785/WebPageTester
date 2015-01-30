# WebPageTester
Automatic testing using webpagetest APIs & PHP

## Download
#### 1. Install composer if you haven't already
~~~
> curl -sS https://getcomposer.org/installer | php
~~~
#### 2. Clone the WebPageTest repository
~~~
> git clone https://github.com/bhargav2785/WebPageTester.git
~~~
## Configuration
Just set the MongoDB details in the file **src/config.ini**
## Installation
~~~
> cd path_to_WebPageTester
> composer install
> php src/Scripts/install.php
~~~
## Usage
~~~
php src/Scripts/test.php [options]
~~~
## Options
~~~
php src/Scripts/test.php --help
~~~

-	**-h, --help** to get the help about this tool.
-	**-u** url mode. Pass the url to test.
- 	**-f** file mode. Pass the file path to test. File can contain multiple urls to test, one on ech line.
-	**-m** master file mode. Pass the master file path to test. Master file can have multiple file names in it. One on each line. Each of those path/url can have a list of test urls.
-	**--save** to save an initial test result into the database.
-	**--check** to check/validate the response coming from WPT suite.
-	**--download** to download all the results/documents for all the test in current run.
-	**-s** path to a spec file. To be used with -u option only when --save param is provided.
-	**--options** to provide custom options for a test(e.g --options=fvonly=1,private=1).

## Modes
**URL Mode:** Use -u to invoke URL mode. In this mode you can execute any single url directly from the command line. If you want to validate the response you can pass the --check option. In this mode if you pass --check mode then you have to pass in the -s option as well because the validator needs to know where is the spec file located.

**<em>Examples:</em>**

~~~
> php src/Scripts/test.php -u http://google.com
> php src/Scripts/test.php -u http://google.com --save
> php src/Scripts/test.php -u http://google.com --save --download
> php src/Scripts/test.php -u http://google.com --save --download --check -s path/to/spec/file
> php src/Scripts/test.php -u http://google.com --save --download --check -s path/to/spec/file --options=private=1,runs=5
~~~

**File Mode:** Use -f to invoke file mode. In this mode you can execute a file from the command line. The file can contain a list of URLs to be tested follwed by option list followed by path to a spec file. So each row is made of three parts 1) test url 2) test options and 3) spec file for the test results. All three parts are separated by a single space character. You can use --check, --save and --download options in this mode. Internally each row of the file will be tested against the URL mode mentioned above. Example file can be found [here](https://raw.githubusercontent.com/bhargav2785/WebPageTester/master/examples/file_mode.txt).

**<em>Examples:</em>**

~~~
> php src/Scripts/test.php -f /www/wpt/tests/urls.txt
> php src/Scripts/test.php -f /www/wpt/tests/urls.txt --save
> php src/Scripts/test.php -f /www/wpt/tests/urls.txt --save --check
> php src/Scripts/test.php -f /www/wpt/tests/urls.txt --save --check --download
~~~

**Master File Mode:** Use -m to invoke master file mode. In this mode you can execute a master file from the command line. The master file can contain a list of other files/paths. Each row can be a path to the file or a remote URL which contains a list of URLs to be tested. This is basically a convenient method to run multiple files with tests in one shot. You can use --check, --save and --download options in this mode. Internally each row of the master file will be tested against the File mode mentioned above. Example file can be found [here](https://raw.githubusercontent.com/bhargav2785/WebPageTester/master/examples/master_mode.txt).

**<em>Examples:</em>**

~~~
> php src/Scripts/test.php -m src/examples/local_master_file.txt
> php src/Scripts/test.php -m src/examples/local_master_file.txt --save
> php src/Scripts/test.php -m src/examples/local_master_file.txt --save --check
> php src/Scripts/test.php -m src/examples/local_master_file.txt --save --check --download
~~~

## Bugs/Suggestions
## License
WTF license
## Change log
**1.0** 2014/12/20 initial version 