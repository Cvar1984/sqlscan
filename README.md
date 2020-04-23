[![ForTheBadge built-by-developers](http://ForTheBadge.com/images/badges/built-by-developers.svg)](https://github.com/Cvar1984)

[![GitHub license](https://img.shields.io/github/license/Naereen/StrapDown.js.svg)](https://github.com/Cvar1984/sqlscan/blob/dev/LICENSE)
[![GitHub release](https://img.shields.io/github/release/Naereen/StrapDown.js.svg)](https://GitHub.com/Cvar1984/sqlscan/releases/)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)](http://makeapullrequest.com)
[![CodeFactor](https://www.codefactor.io/repository/github/cvar1984/sqlscan/badge)](https://www.codefactor.io/repository/github/cvar1984/sqlscan)
[![serps](http://serp-spider.github.io/logo.png)](http://serp-spider.github.io)
# sqlscan
> sqlscan is quick web scanner for find an sql inject point.
> not for educational, this is for hacking.
>
> use sitemap for best result
![sqlscan images](assets/images.gif)
- Simple to use
- Multi platform
- Fast af
- Cool af

## Installation

requires [php](https://php.net ) to run.
### PHP Depencies
 - ext-bz2
 - ext-curl
 - ext-mbstring
> see composer.json for more information
### For PC Linux debian based environments.

```sh
$ sudo apt install php php-bz2 php-curl php-mbstring curl
$ sudo curl https://raw.githubusercontent.com/Cvar1984/sqlscan/dev/build/main.phar --output /usr/local/bin/sqlscan
$ chmod +x /usr/local/bin/sqlscan
$ sqlscan http://example.gov --scan
$ sqlscan list_url.txt --scan
```

### For Android Termux environments

```sh
$ apt install php curl
$ curl https://raw.githubusercontent.com/Cvar1984/sqlscan/dev/build/main.phar --output $PREFIX/bin/sqlscan
$ chmod +x $PREFIX/bin/sqlscan
$ sqlscan http://example.gov --scan
$ sqlscan list_url.txt --scan
```
## build phar from source

download [Box](https://github.com/box-project/box2)
```sh
$ composer install
$ box build
```
## Todo
 - Quick shell code injector
 - Bypass waf
 - Url from json
 - report csv/xml/html/pdf/db ( composer dependcies )
 - multi threads ( pthread )

## License
> Copyright (c) 2019 \<Cvar1984>
>
> Licensed unter the Apache License, Version 2.0 or the MIT license, at your
> option.
>
> ********************************************************************************
>
> Permission is hereby granted, free of charge, to any person obtaining a copy of
> this software and associated documentation files (the "Software"), to deal in
> the Software without restriction, including without limitation the rights to
> use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
> the Software, and to permit persons to whom the Software is furnished to do so,
> subject to the following conditions:
>
> The above copyright notice and this permission notice shall be included in all
> copies or substantial portions of the Software.
>
> THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
> IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
> FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
> COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
> IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
> CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
>
> ********************************************************************************
>
> Licensed under the Apache License, Version 2.0 (the "License");
> you may not use this file except in compliance with the License.
> You may obtain a copy of the License at
>
>   http://www.apache.org/licenses/LICENSE-2.0
>
> Unless required by applicable law or agreed to in writing, software
> distributed under the License is distributed on an "AS IS" BASIS,
> WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
> See the License for the specific language governing permissions and
> limitations under the License.
