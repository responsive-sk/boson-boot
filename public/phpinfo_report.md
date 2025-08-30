# PHP Info Report

**Generated:** 2025-08-28 18:36:52

## System Information

- PHP Version: 8.4.11
- OS: Linux
- Server: Apache/2.4.63 (Unix) PHP/8.4.11## Full phpinfo()

```



body {background-color: #fff; color: #222; font-family: sans-serif;}
pre {margin: 0; font-family: monospace;}
a {color: inherit;}
a:hover {text-decoration: none;}
table {border-collapse: collapse; border: 0; width: 934px; box-shadow: 1px 2px 3px rgba(0, 0, 0, 0.2);}
.center {text-align: center;}
.center table {margin: 1em auto; text-align: left;}
.center th {text-align: center !important;}
td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}
th {position: sticky; top: 0; background: inherit;}
h1 {font-size: 150%;}
h2 {font-size: 125%;}
h2 > a {text-decoration: none;}
h2 > a:hover {text-decoration: underline;}
.p {text-align: left;}
.e {background-color: #ccf; width: 300px; font-weight: bold;}
.h {background-color: #99c; font-weight: bold;}
.v {background-color: #ddd; max-width: 300px; overflow-x: auto; word-wrap: break-word;}
.v i {color: #999;}
img {float: right; border: 0;}
hr {width: 934px; background-color: #ccc; border: 0; height: 1px;}
:root {--php-dark-grey: #333; --php-dark-blue: #4F5B93; --php-medium-blue: #8892BF; --php-light-blue: #E2E4EF; --php-accent-purple: #793862}@media (prefers-color-scheme: dark) {
  body {background: var(--php-dark-grey); color: var(--php-light-blue)}
  .h td, td.e, th {border-color: #606A90}
  td {border-color: #505153}
  .e {background-color: #404A77}
  .h {background-color: var(--php-dark-blue)}
  .v {background-color: var(--php-dark-grey)}
  hr {background-color: #505153}
}

PHP 8.4.11 - phpinfo()



PHP Version 8.4.11



System Linux ryzen9 6.16.1-arch1-1 #1 SMP PREEMPT_DYNAMIC Fri, 15 Aug 2025 16:04:43 +0000 x86_64 
Build Date Jul 31 2025 15:55:26 
Build System Linux arch-nspawn-438801 6.15.8-arch1-2 #1 SMP PREEMPT_DYNAMIC Tue, 29 Jul 2025 15:05:00 +0000 x86_64 GNU/Linux 
Configure Command  &#039;./configure&#039;  &#039;--srcdir=../php-8.4.11&#039; &#039;--config-cache&#039; &#039;--prefix=/usr&#039; &#039;--sbindir=/usr/bin&#039; &#039;--sysconfdir=/etc/php&#039; &#039;--localstatedir=/var&#039; &#039;--with-layout=GNU&#039; &#039;--with-config-file-path=/etc/php&#039; &#039;--with-config-file-scan-dir=/etc/php/conf.d&#039; &#039;--disable-rpath&#039; &#039;--mandir=/usr/share/man&#039; &#039;--with-apxs2&#039; &#039;--enable-bcmath=shared&#039; &#039;--enable-calendar=shared&#039; &#039;--enable-dba=shared&#039; &#039;--enable-exif=shared&#039; &#039;--enable-ftp=shared&#039; &#039;--enable-gd=shared&#039; &#039;--enable-intl=shared&#039; &#039;--enable-mbstring&#039; &#039;--enable-pcntl&#039; &#039;--enable-shmop=shared&#039; &#039;--enable-soap=shared&#039; &#039;--enable-sockets=shared&#039; &#039;--enable-sysvmsg=shared&#039; &#039;--enable-sysvsem=shared&#039; &#039;--enable-sysvshm=shared&#039; &#039;--with-bz2=shared&#039; &#039;--with-curl=shared&#039; &#039;--with-enchant=shared&#039; &#039;--with-external-gd&#039; &#039;--with-external-pcre&#039; &#039;--with-ffi=shared&#039; &#039;--with-gdbm&#039; &#039;--with-gettext=shared&#039; &#039;--with-gmp=shared&#039; &#039;--with-iconv=shared&#039; &#039;--with-ldap=shared&#039; &#039;--with-ldap-sasl&#039; &#039;--with-mhash&#039; &#039;--with-mysql-sock=/run/mysqld/mysqld.sock&#039; &#039;--with-mysqli=shared&#039; &#039;--with-openssl&#039; &#039;--with-openssl-argon2&#039; &#039;--with-password-argon2&#039; &#039;--with-pdo-dblib=shared,/usr&#039; &#039;--with-pdo-mysql=shared&#039; &#039;--with-pdo-odbc=shared,unixODBC,/usr&#039; &#039;--with-pdo-pgsql=shared&#039; &#039;--with-pdo-sqlite=shared&#039; &#039;--with-pgsql=shared&#039; &#039;--with-readline&#039; &#039;--with-snmp=shared&#039; &#039;--with-sodium=shared&#039; &#039;--with-sqlite3=shared&#039; &#039;--with-tidy=shared&#039; &#039;--with-unixODBC=shared&#039; &#039;--with-xsl=shared&#039; &#039;--with-zip=shared&#039; &#039;--with-zlib&#039; &#039;CFLAGS=-march=x86-64 -mtune=generic -O2 -pipe -fno-plt -fexceptions -Wp,-D_FORTIFY_SOURCE=3 -Wformat -Werror=format-security -fstack-clash-protection -fcf-protection -fno-omit-frame-pointer -mno-omit-leaf-frame-pointer -g -ffile-prefix-map=/build/php/src=/usr/src/debug/php&#039; &#039;LDFLAGS=-Wl,-O1 -Wl,--sort-common -Wl,--as-needed -Wl,-z,relro -Wl,-z,now -Wl,-z,pack-relative-relocs&#039; &#039;CXXFLAGS=-march=x86-64 -mtune=generic -O2 -pipe -fno-plt -fexceptions -Wp,-D_FORTIFY_SOURCE=3 -Wformat -Werror=format-security -fstack-clash-protection -fcf-protection -fno-omit-frame-pointer -mno-omit-leaf-frame-pointer -Wp,-D_GLIBCXX_ASSERTIONS -g -ffile-prefix-map=/build/php/src=/usr/src/debug/php&#039; &#039;EXTENSION_DIR=/usr/lib/php/modules&#039; 
Server API Apache 2 Handler 
Virtual Directory Support disabled 
Configuration File (php.ini) Path /etc/php 
Loaded Configuration File /etc/php/php.ini 
Scan this dir for additional .ini files /etc/php/conf.d 
Additional .ini files parsed /etc/php/conf.d/apcu.ini,
/etc/php/conf.d/igbinary.ini,
/etc/php/conf.d/imagick.ini,
/etc/php/conf.d/redis.ini,
/etc/php/conf.d/xdebug.ini
 
PHP API 20240924 
PHP Extension 20240924 
Zend Extension 420240924 
Zend Extension Build API420240924,NTS 
PHP Extension Build API20240924,NTS 
PHP Integer Size 64 bits 
Debug Build no 
Thread Safety disabled 
Zend Signal Handling enabled 
Zend Memory Manager enabled 
Zend Multibyte Support provided by mbstring 
Zend Max Execution Timers disabled 
IPv6 Support enabled 
DTrace Support disabled 
Registered PHP Streamscompress.zlib, php, file, glob, data, http, ftp, compress.bzip2, https, ftps, phar, zip
Registered Stream Socket Transportstcp, udp, unix, udg, ssl, tls, tlsv1.0, tlsv1.1, tlsv1.2, tlsv1.3
Registered Stream Filterszlib.*, string.rot13, string.toupper, string.tolower, convert.*, consumed, dechunk, bzip2.*, convert.iconv.*




This program makes use of the Zend Scripting Language Engine:Zend Engine v4.4.11, Copyright (c) Zend Technologies
    with Zend OPcache v8.4.11, Copyright (c), by Zend Technologies
    with Xdebug v3.4.4, Copyright (c) 2002-2025, by Derick Rethans



Configuration
apache2handler

Apache Version Apache/2.4.63 (Unix) PHP/8.4.11 
Apache API Version 20120211 
Server Administrator you@example.com 
Hostname:Port localhost:0 
User/Group http(33)/33 
Max Requests Per Child: 0 - Keep Alive: on - Max Per Connection: 100 
Timeouts Connection: 60 - Keep-Alive: 5 
Virtual Server No 
Server Root /etc/httpd 
Loaded Modules core mod_so http_core prefork mod_authn_file mod_authn_core mod_authz_host mod_authz_groupfile mod_authz_user mod_authz_core mod_access_compat mod_auth_basic mod_reqtimeout mod_include mod_filter mod_mime mod_log_config mod_env mod_headers mod_setenvif mod_version mod_slotmem_shm mod_unixd mod_status mod_autoindex mod_negotiation mod_dir mod_userdir mod_alias mod_rewrite mod_php 


DirectiveLocal ValueMaster Value
engineOnOn
last_modifiedOffOff
xbithackOffOff

Apache Environment

VariableValue
HTTP_HOST localhost 
HTTP_USER_AGENT Mozilla/5.0 (X11; Linux x86_64; rv:141.0) Gecko/20100101 Firefox/141.0 
HTTP_ACCEPT text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8 
HTTP_ACCEPT_LANGUAGE en-US,en;q=0.5 
HTTP_ACCEPT_ENCODING gzip, deflate, br, zstd 
HTTP_CONNECTION keep-alive 
HTTP_COOKIE PHPSESSID=19c0901bbe93a5a099d48aae84f5e40e; BOSON_SESSION=e47e7fa35dd23c3592205102c57902b4 
HTTP_UPGRADE_INSECURE_REQUESTS 1 
HTTP_SEC_FETCH_DEST document 
HTTP_SEC_FETCH_MODE navigate 
HTTP_SEC_FETCH_SITE none 
HTTP_SEC_FETCH_USER ?1 
HTTP_PRIORITY u=0, i 
PATH /usr/local/sbin:/usr/local/bin:/usr/bin 
SERVER_SIGNATURE no value 
SERVER_SOFTWARE Apache/2.4.63 (Unix) PHP/8.4.11 
SERVER_NAME localhost 
SERVER_ADDR 127.0.0.1 
SERVER_PORT 80 
REMOTE_ADDR 127.0.0.1 
DOCUMENT_ROOT /srv/http/minimal/public 
REQUEST_SCHEME http 
CONTEXT_PREFIX no value 
CONTEXT_DOCUMENT_ROOT /srv/http/minimal/public 
SERVER_ADMIN you@example.com 
SCRIPT_FILENAME /srv/http/minimal/public/info-md.php 
REMOTE_PORT 51112 
GATEWAY_INTERFACE CGI/1.1 
SERVER_PROTOCOL HTTP/1.1 
REQUEST_METHOD GET 
QUERY_STRING no value 
REQUEST_URI /info-md.php 
SCRIPT_NAME /info-md.php 

HTTP Headers Information

HTTP Request Headers
HTTP Request GET /info-md.php HTTP/1.1 
Host localhost 
User-Agent Mozilla/5.0 (X11; Linux x86_64; rv:141.0) Gecko/20100101 Firefox/141.0 
Accept text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8 
Accept-Language en-US,en;q=0.5 
Accept-Encoding gzip, deflate, br, zstd 
Connection keep-alive 
Cookie PHPSESSID=19c0901bbe93a5a099d48aae84f5e40e; BOSON_SESSION=e47e7fa35dd23c3592205102c57902b4 
Upgrade-Insecure-Requests 1 
Sec-Fetch-Dest document 
Sec-Fetch-Mode navigate 
Sec-Fetch-Site none 
Sec-Fetch-User ?1 
Priority u=0, i 
HTTP Response Headers
X-Powered-By PHP/8.4.11 

apcu

APCu Support Enabled 
Version 5.1.26 
APCu Debugging Disabled 
MMAP Support Enabled 
MMAP File Mask no value 
Serialization Support php 
Build Date Aug  7 2025 18:30:31 


DirectiveLocal ValueMaster Value
apc.coredump_unmapOffOff
apc.enable_cliOffOff
apc.enabledOnOn
apc.entries_hint00
apc.gc_ttl36003600
apc.mmap_file_maskno valueno value
apc.mmap_hugepage_size00
apc.preload_pathno valueno value
apc.serializerphpphp
apc.shm_size32M32M
apc.slam_defenseOffOff
apc.smart00
apc.ttl00
apc.use_request_timeOffOff

bcmath

BCMath support enabled 


DirectiveLocal ValueMaster Value
bcmath.scale00

bz2

BZip2 Support Enabled 
Stream Wrapper support compress.bzip2:// 
Stream Filter support bzip2.decompress, bzip2.compress 
BZip2 Version 1.0.8, 13-Jul-2019 

calendar

Calendar support enabled 

Core

PHP Version 8.4.11 


DirectiveLocal ValueMaster Value
allow_url_fopenOnOn
allow_url_includeOffOff
arg_separator.input&amp;&amp;
arg_separator.output&amp;&amp;
auto_append_fileno valueno value
auto_globals_jitOnOn
auto_prepend_fileno valueno value
browscapno valueno value
default_charsetUTF-8UTF-8
default_mimetypetext/htmltext/html
disable_classesno valueno value
disable_functionsno valueno value
display_errorsOffOff
display_startup_errorsOffOff
doc_rootno valueno value
docref_extno valueno value
docref_rootno valueno value
enable_dlOffOff
enable_post_data_readingOnOn
error_append_stringno valueno value
error_logno valueno value
error_log_mode06440644
error_prepend_stringno valueno value
error_reporting2252722527
expose_phpOnOn
extension_dir/usr/lib/php/modules//usr/lib/php/modules/
fiber.stack_sizeno valueno value
file_uploadsOnOn
hard_timeout22
highlight.comment#FF8000#FF8000
highlight.default#0000BB#0000BB
highlight.html#000000#000000
highlight.keyword#007700#007700
highlight.string#DD0000#DD0000
html_errorsOnOn
ignore_repeated_errorsOffOff
ignore_repeated_sourceOffOff
ignore_user_abortOffOff
implicit_flushOffOff
include_path.:.:
input_encodingno valueno value
internal_encodingno valueno value
log_errorsOnOn
mail.add_x_headerOffOff
mail.force_extra_parametersno valueno value
mail.logno valueno value
mail.mixed_lf_and_crlfOffOff
max_execution_time3030
max_file_uploads2020
max_input_nesting_level6464
max_input_time6060
max_input_vars10001000
max_multipart_body_parts-1-1
memory_limit512M512M
open_basedirno valueno value
output_buffering40964096
output_encodingno valueno value
output_handlerno valueno value
post_max_size8M8M
precision1414
realpath_cache_size4096K4096K
realpath_cache_ttl120120
register_argc_argvOffOff
report_memleaksOnOn
report_zend_debugOffOff
request_orderGPGP
sendmail_fromno valueno value
sendmail_path/usr/bin/sendmail -t -i/usr/bin/sendmail -t -i
serialize_precision-1-1
short_open_tagOffOff
SMTPlocalhostlocalhost
smtp_port2525
sys_temp_dirno valueno value
syslog.facilityLOG_USERLOG_USER
syslog.filterno-ctrlno-ctrl
syslog.identphpphp
unserialize_callback_funcno valueno value
upload_max_filesize2M2M
upload_tmp_dirno valueno value
user_dirno valueno value
user_ini.cache_ttl300300
user_ini.filename.user.ini.user.ini
variables_orderGPCSGPCS
xmlrpc_error_number00
xmlrpc_errorsOffOff
zend.assertions-1-1
zend.detect_unicodeOnOn
zend.enable_gcOnOn
zend.exception_ignore_argsOnOn
zend.exception_string_param_max_len00
zend.max_allowed_stack_size00
zend.multibyteOffOff
zend.reserved_stack_size00
zend.script_encodingno valueno value
zend.signal_checkOffOff

ctype

ctype functions enabled 

curl

cURL support enabled 
cURL Information 8.15.0 
Age 11 
Features 
AsynchDNS Yes 
CharConv No 
Debug No 
GSS-Negotiate No 
IDN Yes 
IPv6 Yes 
krb4 No 
Largefile Yes 
libz Yes 
NTLM Yes 
NTLMWB No 
SPNEGO Yes 
SSL Yes 
SSPI No 
TLS-SRP Yes 
HTTP2 Yes 
GSSAPI Yes 
KERBEROS5 Yes 
UNIX_SOCKETS Yes 
PSL Yes 
HTTPS_PROXY Yes 
MULTI_SSL No 
BROTLI Yes 
ALTSVC Yes 
HTTP3 Yes 
UNICODE No 
ZSTD Yes 
HSTS Yes 
GSASL No 
Protocols dict, file, ftp, ftps, gopher, gophers, http, https, imap, imaps, mqtt, pop3, pop3s, rtsp, scp, sftp, smb, smbs, smtp, smtps, telnet, tftp, ws, wss 
Host x86_64-pc-linux-gnu 
SSL Version OpenSSL/3.5.2 
ZLib Version 1.3.1 
libSSH Version libssh2/1.11.1 


DirectiveLocal ValueMaster Value
curl.cainfono valueno value

date

date/time support enabled 
timelib version 2022.12 
&quot;Olson&quot; Timezone Database Version 2025.2 
Timezone Database internal 
Default timezone UTC 


DirectiveLocal ValueMaster Value
date.default_latitude31.766731.7667
date.default_longitude35.233335.2333
date.sunrise_zenith90.83333390.833333
date.sunset_zenith90.83333390.833333
date.timezoneUTCUTC

dom

DOM/XML enabled 
DOM/XML API Version 20031129 
libxml Version 2.14.5 
HTML Support enabled 
XPath Support enabled 
XPointer Support enabled 
Schema Support enabled 
RelaxNG Support enabled 

exif

EXIF Support enabled 
Supported EXIF Version 0220 
Supported filetypes JPEG, TIFF 
Multibyte decoding support using mbstring enabled 
Extended EXIF tag formats Canon, Casio, Fujifilm, Nikon, Olympus, Samsung, Panasonic, DJI, Sony, Pentax, Minolta, Sigma, Foveon, Kyocera, Ricoh, AGFA, Epson 


DirectiveLocal ValueMaster Value
exif.decode_jis_intelJISJIS
exif.decode_jis_motorolaJISJIS
exif.decode_unicode_intelUCS-2LEUCS-2LE
exif.decode_unicode_motorolaUCS-2BEUCS-2BE
exif.encode_jisno valueno value
exif.encode_unicodeISO-8859-15ISO-8859-15

fileinfo

fileinfo support enabled 
libmagic 545 

filter

Input Validation and Filtering enabled 


DirectiveLocal ValueMaster Value
filter.defaultunsafe_rawunsafe_raw
filter.default_flagsno valueno value

ftp

FTP support enabled 
FTPS support enabled 

gd

GD Support enabled 
GD headers Version 2.3.3 
GD library Version 2.3.3 
FreeType Support enabled 
FreeType Linkage with freetype 
GIF Read Support enabled 
GIF Create Support enabled 
JPEG Support enabled 
PNG Support enabled 
WBMP Support enabled 
XPM Support enabled 
XBM Support enabled 
WebP Support enabled 
BMP Support enabled 
AVIF Support enabled 
TGA Read Support enabled 


DirectiveLocal ValueMaster Value
gd.jpeg_ignore_warningOnOn

gettext

GetText Support enabled 

gmp

gmp support enabled 
GMP version 6.3.0 

hash

hash support enabled 
Hashing Engines md2 md4 md5 sha1 sha224 sha256 sha384 sha512/224 sha512/256 sha512 sha3-224 sha3-256 sha3-384 sha3-512 ripemd128 ripemd160 ripemd256 ripemd320 whirlpool tiger128,3 tiger160,3 tiger192,3 tiger128,4 tiger160,4 tiger192,4 snefru snefru256 gost gost-crypto adler32 crc32 crc32b crc32c fnv132 fnv1a32 fnv164 fnv1a64 joaat murmur3a murmur3c murmur3f xxh32 xxh64 xxh3 xxh128 haval128,3 haval160,3 haval192,3 haval224,3 haval256,3 haval128,4 haval160,4 haval192,4 haval224,4 haval256,4 haval128,5 haval160,5 haval192,5 haval224,5 haval256,5  


MHASH support Enabled 
MHASH API Version Emulated Support 

iconv

iconv support enabled 
iconv implementation glibc 
iconv library version 2.42 


DirectiveLocal ValueMaster Value
iconv.input_encodingno valueno value
iconv.internal_encodingno valueno value
iconv.output_encodingno valueno value

imagick

imagick moduleenabled
imagick module version 3.8.0 
imagick classes Imagick, ImagickDraw, ImagickPixel, ImagickPixelIterator, ImagickKernel 
Imagick compiled with ImageMagick version ImageMagick 7.1.2-0 Q16-HDRI x86_64 23234 https://imagemagick.org 
Imagick using ImageMagick library version ImageMagick 7.1.2-1 Q16-HDRI x86_64 23308 https://imagemagick.org 
ImageMagick copyright (C) 1999 ImageMagick Studio LLC 
ImageMagick release date 2025-08-12 
ImageMagick number of supported formats:  275 
ImageMagick supported formats 3FR, 3G2, 3GP, AAI, AI, APNG, ART, ARW, ASHLAR, AVCI, AVI, AVIF, AVS, BAYER, BAYERA, BGR, BGRA, BGRO, BIE, BMP, BMP2, BMP3, BRF, CAL, CALS, CANVAS, CAPTION, CIN, CIP, CLIP, CMYK, CMYKA, CR2, CR3, CRW, CUBE, CUR, CUT, DATA, DCM, DCR, DCRAW, DCX, DDS, DFONT, DJVU, DNG, DOT, DPX, DXT1, DXT5, EPDF, EPI, EPS, EPS2, EPS3, EPSF, EPSI, EPT, EPT2, EPT3, ERF, EXR, FARBFELD, FAX, FF, FFF, FILE, FITS, FL32, FLV, FRACTAL, FTP, FTS, FTXT, G3, G4, GIF, GIF87, GRADIENT, GRAY, GRAYA, GROUP4, GV, HALD, HDR, HEIC, HEIF, HISTOGRAM, HRZ, HTM, HTML, HTTP, HTTPS, ICB, ICN, ICO, ICON, IIQ, INFO, INLINE, IPL, ISOBRL, ISOBRL6, J2C, J2K, JBG, JBIG, JNG, JNX, JP2, JPC, JPE, JPEG, JPG, JPM, JPS, JPT, JSON, JXL, K25, KDC, KERNEL, LABEL, M2V, M4V, MAC, MAP, MASK, MAT, MATTE, MDC, MEF, MIFF, MKV, MNG, MONO, MOS, MOV, MP4, MPC, MPEG, MPG, MPO, MRW, MSL, MSVG, MTV, MVG, NEF, NRW, NULL, ORA, ORF, OTB, OTF, PAL, PALM, PAM, PANGO, PATTERN, PBM, PCD, PCDS, PCL, PCT, PCX, PDB, PDF, PDFA, PEF, PES, PFA, PFB, PFM, PGM, PGX, PHM, PICON, PICT, PIX, PJPEG, PLASMA, PNG, PNG00, PNG24, PNG32, PNG48, PNG64, PNG8, PNM, POCKETMOD, PPM, PS, PS2, PS3, PSB, PSD, PTIF, PWP, QOI, RADIAL-GRADIENT, RAF, RAS, RAW, RGB, RGB565, RGBA, RGBO, RGF, RLA, RLE, RMF, RSVG, RW2, RWL, SCR, SCT, SF3, SFW, SGI, SHTML, SIX, SIXEL, SPARSE-COLOR, SR2, SRF, SRW, STEGANO, STI, STRIMG, SUN, SVG, SVGZ, TEXT, TGA, THUMBNAIL, TIFF, TIFF64, TILE, TIM, TM2, TTC, TTF, TXT, UBRL, UBRL6, UIL, UYVY, VDA, VICAR, VID, VIFF, VIPS, VST, WBMP, WEBM, WEBP, WMF, WMV, WMZ, WPG, X, X3F, XBM, XC, XCF, XPM, XPS, XV, XWD, YAML, YCBCR, YCBCRA, YUV 


DirectiveLocal ValueMaster Value
imagick.allow_zero_dimension_images00
imagick.locale_fix00
imagick.progress_monitor00
imagick.set_single_thread11
imagick.shutdown_sleep_count1010
imagick.skip_version_check00

intl

Internationalization support enabled 
ICU version 76.1 
ICU Data version 76.1 
ICU TZData version 2024b 
ICU Unicode version 16.0 


DirectiveLocal ValueMaster Value
intl.default_localeno valueno value
intl.error_level00
intl.use_exceptionsOffOff

json

json support enabled 

libxml

libXML support active 
libXML Compiled Version 2.14.5 
libXML Loaded Version 21405-GITv2.14.5 
libXML streams enabled 

mbstring

Multibyte Support enabled 
Multibyte string engine libmbfl 
HTTP input encoding translation disabled 
libmbfl version 1.3.2 


mbstring extension makes use of "streamable kanji code filter and converter", which is distributed under the GNU Lesser General Public License version 2.1.


Multibyte (japanese) regex support enabled 
Multibyte regex (oniguruma) version 6.9.10 


DirectiveLocal ValueMaster Value
mbstring.detect_orderno valueno value
mbstring.encoding_translationOffOff
mbstring.http_inputno valueno value
mbstring.http_outputno valueno value
mbstring.http_output_conv_mimetypes^(text/|application/xhtml\+xml)^(text/|application/xhtml\+xml)
mbstring.internal_encodingno valueno value
mbstring.languageneutralneutral
mbstring.regex_retry_limit10000001000000
mbstring.regex_stack_limit100000100000
mbstring.strict_detectionOffOff
mbstring.substitute_characterno valueno value

mysqli

MysqlI Support enabled 
Client API library version mysqlnd 8.4.11 
Active Persistent Links 0 
Inactive Persistent Links 0 
Active Links 0 


DirectiveLocal ValueMaster Value
mysqli.allow_local_infileOffOff
mysqli.allow_persistentOnOn
mysqli.default_hostno valueno value
mysqli.default_port33063306
mysqli.default_pwno valueno value
mysqli.default_socket/run/mysqld/mysqld.sock/run/mysqld/mysqld.sock
mysqli.default_userno valueno value
mysqli.local_infile_directoryno valueno value
mysqli.max_linksUnlimitedUnlimited
mysqli.max_persistentUnlimitedUnlimited
mysqli.rollback_on_cached_plinkOffOff

mysqlnd

mysqlnd enabled 
Version mysqlnd 8.4.11 
Compression supported 
core SSL supported 
extended SSL supported 
Command buffer size 4096 
Read buffer size 32768 
Read timeout 86400 
Collecting statistics Yes 
Collecting memory statistics No 
Tracing n/a 
Loaded plugins mysqlnd,debug_trace,auth_plugin_mysql_native_password,auth_plugin_mysql_clear_password,auth_plugin_caching_sha2_password,auth_plugin_sha256_password 
API Extensions mysqli,pdo_mysql 

openssl

OpenSSL support enabled 
OpenSSL Library Version OpenSSL 3.5.2 5 Aug 2025 
OpenSSL Header Version OpenSSL 3.5.1 1 Jul 2025 
Openssl default config /etc/ssl/openssl.cnf 


DirectiveLocal ValueMaster Value
openssl.cafileno valueno value
openssl.capathno valueno value

pcre

PCRE (Perl Compatible Regular Expressions) Support enabled 
PCRE Library Version 10.45 2025-02-05 
PCRE Unicode Version 16.0.0 
PCRE JIT Support enabled 
PCRE JIT Target x86 64bit (little endian + unaligned) 


DirectiveLocal ValueMaster Value
pcre.backtrack_limit10000001000000
pcre.jitOnOn
pcre.recursion_limit100000100000

PDO

PDO support enabled 
PDO drivers mysql, sqlite 

pdo_mysql

PDO Driver for MySQL enabled 
Client API version mysqlnd 8.4.11 


DirectiveLocal ValueMaster Value
pdo_mysql.default_socket/run/mysqld/mysqld.sock/run/mysqld/mysqld.sock

pdo_sqlite

PDO Driver for SQLite 3.x enabled 
SQLite Library 3.50.4 

Phar

Phar: PHP Archive support enabled 
Phar API version 1.1.1 
Phar-based phar archives enabled 
Tar-based phar archives enabled 
ZIP-based phar archives enabled 
gzip compression enabled 
bzip2 compression enabled 
Native OpenSSL support enabled 



Phar based on pear/PHP_Archive, original concept by Davey Shafik.Phar fully realized by Gregory Beaver and Marcus Boerger.Portions of tar implementation Copyright (c) 2003-2009 Tim Kientzle.


DirectiveLocal ValueMaster Value
phar.cache_listno valueno value
phar.readonlyOnOn
phar.require_hashOnOn

posix

POSIX support enabled 

random

Version 8.4.11 

Reflection

Reflection enabled 

session

Session Support enabled 
Registered save handlers files user  
Registered serializer handlers php_serialize php php_binary  


DirectiveLocal ValueMaster Value
session.auto_startOffOff
session.cache_expire180180
session.cache_limiternocachenocache
session.cookie_domainno valueno value
session.cookie_httponlyOffOff
session.cookie_lifetime00
session.cookie_path//
session.cookie_samesiteno valueno value
session.cookie_secureOffOff
session.gc_divisor10001000
session.gc_maxlifetime14401440
session.gc_probability11
session.lazy_writeOnOn
session.namePHPSESSIDPHPSESSID
session.referer_checkno valueno value
session.save_handlerfilesfiles
session.save_pathno valueno value
session.serialize_handlerphpphp
session.sid_bits_per_character44
session.sid_length3232
session.upload_progress.cleanupOnOn
session.upload_progress.enabledOnOn
session.upload_progress.freq1%1%
session.upload_progress.min_freq11
session.upload_progress.namePHP_SESSION_UPLOAD_PROGRESSPHP_SESSION_UPLOAD_PROGRESS
session.upload_progress.prefixupload_progress_upload_progress_
session.use_cookiesOnOn
session.use_only_cookiesOnOn
session.use_strict_modeOffOff
session.use_trans_sidOffOff

SimpleXML

SimpleXML support enabled 
Schema support enabled 

snmp

NET-SNMP Support enabled 
NET-SNMP Version 5.9.4.pre2 

soap

Soap Client enabled 
Soap Server enabled 


DirectiveLocal ValueMaster Value
soap.wsdl_cache11
soap.wsdl_cache_dir/tmp/tmp
soap.wsdl_cache_enabledOnOn
soap.wsdl_cache_limit55
soap.wsdl_cache_ttl8640086400

sockets

Sockets Support enabled 

SPL

SPL support enabled 
Interfaces OuterIterator, RecursiveIterator, SeekableIterator, SplObserver, SplSubject 
Classes AppendIterator, ArrayIterator, ArrayObject, BadFunctionCallException, BadMethodCallException, CachingIterator, CallbackFilterIterator, DirectoryIterator, DomainException, EmptyIterator, FilesystemIterator, FilterIterator, GlobIterator, InfiniteIterator, InvalidArgumentException, IteratorIterator, LengthException, LimitIterator, LogicException, MultipleIterator, NoRewindIterator, OutOfBoundsException, OutOfRangeException, OverflowException, ParentIterator, RangeException, RecursiveArrayIterator, RecursiveCachingIterator, RecursiveCallbackFilterIterator, RecursiveDirectoryIterator, RecursiveFilterIterator, RecursiveIteratorIterator, RecursiveRegexIterator, RecursiveTreeIterator, RegexIterator, RuntimeException, SplDoublyLinkedList, SplFileInfo, SplFileObject, SplFixedArray, SplHeap, SplMinHeap, SplMaxHeap, SplObjectStorage, SplPriorityQueue, SplQueue, SplStack, SplTempFileObject, UnderflowException, UnexpectedValueException 

sqlite3

SQLite3 support enabled 
SQLite Library 3.50.4 


DirectiveLocal ValueMaster Value
sqlite3.defensiveOnOn
sqlite3.extension_dirno valueno value

standard

Dynamic Library Support enabled 
Path to sendmail /usr/bin/sendmail -t -i 


DirectiveLocal ValueMaster Value
assert.activeOnOn
assert.bailOffOff
assert.callbackno valueno value
assert.exceptionOnOn
assert.warningOnOn
auto_detect_line_endingsOffOff
default_socket_timeout6060
fromno valueno value
session.trans_sid_hostsno valueno value
session.trans_sid_tagsa=href,area=href,frame=src,form=a=href,area=href,frame=src,form=
unserialize_max_depth40964096
url_rewriter.hostsno valueno value
url_rewriter.tagsform=form=
user_agentno valueno value

tokenizer

Tokenizer Support enabled 

xdebug

Xdebug
Version 3.4.4 
Support Xdebug on Patreon, GitHub, or as a business


Enabled Features(through 'xdebug.mode' setting)
FeatureEnabled/DisabledDocs
Development Helpers✔ enabled⊕
Coverage✘ disabled⊕
GC Stats✘ disabled⊕
Profiler✘ disabled⊕
Step Debugger✔ enabled⊕
Tracing✘ disabled⊕


Optional Features
Compressed File Support yes (gzip) 
Clock Source clock_gettime 
TSC Clock Source available 
&#039;xdebug://gateway&#039; pseudo-host support yes 
&#039;xdebug://nameserver&#039; pseudo-host support yes 
Systemd Private Temp Directory not enabled 


Debuggerenabled
IDE Key no value 


DirectiveLocal ValueMaster Value
xdebug.auto_trace(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.cli_color00
xdebug.client_discovery_headerHTTP_X_FORWARDED_FOR,REMOTE_ADDRHTTP_X_FORWARDED_FOR,REMOTE_ADDR
xdebug.client_hostlocalhostlocalhost
xdebug.client_port90039003
xdebug.cloud_idno valueno value
xdebug.collect_assignmentsOffOff
xdebug.collect_includes(setting removed in Xdebug 3)(setting removed in Xdebug 3)
xdebug.collect_paramsOnOn
xdebug.collect_returnOffOff
xdebug.collect_vars(setting removed in Xdebug 3)(setting removed in Xdebug 3)
xdebug.connect_timeout_ms200200
xdebug.control_sockettime: 25mstime: 25ms
xdebug.coverage_enable(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.default_enable(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.discover_client_hostOnOn
xdebug.dump.COOKIEno valueno value
xdebug.dump.ENVno valueno value
xdebug.dump.FILESno valueno value
xdebug.dump.GETno valueno value
xdebug.dump.POSTno valueno value
xdebug.dump.REQUESTno valueno value
xdebug.dump.SERVERno valueno value
xdebug.dump.SESSIONno valueno value
xdebug.dump_globalsOnOn
xdebug.dump_onceOnOn
xdebug.dump_undefinedOffOff
xdebug.file_link_formatno valueno value
xdebug.filename_formatno valueno value
xdebug.force_display_errorsOffOff
xdebug.force_error_reporting00
xdebug.gc_stats_enable(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.gc_stats_output_dir(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.gc_stats_output_namegcstats.%pgcstats.%p
xdebug.halt_level00
xdebug.idekeyno valueno value
xdebug.logno valueno value
xdebug.log_level77
xdebug.max_nesting_level512512
xdebug.max_stack_frames-1-1
xdebug.modedevelop,debugdevelop,debug
xdebug.output_dir/tmp/tmp
xdebug.overload_var_dump(setting removed in Xdebug 3)(setting removed in Xdebug 3)
xdebug.profiler_appendOffOff
xdebug.profiler_enable(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.profiler_enable_trigger(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.profiler_enable_trigger_value(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.profiler_output_dir(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.profiler_output_namecachegrind.out.%pcachegrind.out.%p
xdebug.remote_autostart(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.remote_connect_back(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.remote_enable(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.remote_host(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.remote_log(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.remote_log_level(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.remote_mode(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.remote_port(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.remote_timeout(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.screamOffOff
xdebug.show_error_traceOffOff
xdebug.show_exception_traceOffOff
xdebug.show_local_varsOffOff
xdebug.show_mem_delta(setting removed in Xdebug 3)(setting removed in Xdebug 3)
xdebug.start_upon_errordefaultdefault
xdebug.start_with_requestyesyes
xdebug.trace_enable_trigger(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.trace_enable_trigger_value(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.trace_format00
xdebug.trace_options00
xdebug.trace_output_dir(setting renamed in Xdebug 3)(setting renamed in Xdebug 3)
xdebug.trace_output_nametrace.%ctrace.%c
xdebug.trigger_valueno valueno value
xdebug.use_compression11
xdebug.var_display_max_children128128
xdebug.var_display_max_data512512
xdebug.var_display_max_depth33

xml

XML Support active 
XML Namespace Support active 
libxml2 Version 2.14.5 

xmlreader

XMLReader enabled 

xmlwriter

XMLWriter enabled 

Zend OPcache

Opcode Caching Up and Running 
Optimization Disabled 
SHM Cache Enabled 
File Cache Disabled 
JIT Disabled 
Startup OK 
Shared memory model mmap 
Cache hits 667 
Cache misses 71 
Used memory 10035520 
Free memory 124094552 
Wasted memory 87656 
Interned Strings Used memory 2840808 
Interned Strings Free memory 5547800 
Cached scripts 67 
Cached keys 117 
Max keys 16229 
OOM restarts 0 
Hash keys restarts 0 
Manual restarts 0 
Start time 2025-08-28T16:59:32+0000 
Last restart time none 
Last force restart time none 


DirectiveLocal ValueMaster Value
opcache.blacklist_filenameno valueno value
opcache.dups_fixOffOff
opcache.enableOnOn
opcache.enable_cliOffOff
opcache.enable_file_overrideOffOff
opcache.error_logno valueno value
opcache.file_cacheno valueno value
opcache.file_cache_consistency_checksOnOn
opcache.file_cache_onlyOffOff
opcache.file_update_protection22
opcache.force_restart_timeout180180
opcache.huge_code_pagesOffOff
opcache.interned_strings_buffer88
opcache.jitdisabledisable
opcache.jit_bisect_limit00
opcache.jit_blacklist_root_trace1616
opcache.jit_blacklist_side_trace88
opcache.jit_buffer_size64M64M
opcache.jit_debug00
opcache.jit_hot_func127127
opcache.jit_hot_loop6464
opcache.jit_hot_return88
opcache.jit_hot_side_exit88
opcache.jit_max_exit_counters81928192
opcache.jit_max_loop_unrolls88
opcache.jit_max_polymorphic_calls22
opcache.jit_max_recursive_calls22
opcache.jit_max_recursive_returns22
opcache.jit_max_root_traces10241024
opcache.jit_max_side_traces128128
opcache.jit_max_trace_length10241024
opcache.jit_prof_threshold0.0050.005
opcache.lockfile_path/tmp/tmp
opcache.log_verbosity_level11
opcache.max_accelerated_files1000010000
opcache.max_file_size00
opcache.max_wasted_percentage55
opcache.memory_consumption128128
opcache.opt_debug_level00
opcache.optimization_level00x7FFEBFFF
opcache.preferred_memory_modelno valueno value
opcache.preloadno valueno value
opcache.preload_userno valueno value
opcache.protect_memoryOffOff
opcache.record_warningsOffOff
opcache.restrict_apino valueno value
opcache.revalidate_freq22
opcache.revalidate_pathOffOff
opcache.save_commentsOnOn
opcache.use_cwdOnOn
opcache.validate_permissionOffOff
opcache.validate_rootOffOff
opcache.validate_timestampsOnOn

zip

Zip enabled 
Zip version 1.22.6 
Libzip version 1.11.4 
BZIP2 compression Yes 
XZ compression Yes 
ZSTD compression Yes 
AES-128 encryption Yes 
AES-192 encryption Yes 
AES-256 encryption Yes 

zlib

ZLib Support enabled 
Stream Wrapper compress.zlib:// 
Stream Filter zlib.inflate, zlib.deflate 
Compiled Version 1.3.1 
Linked Version 1.3.1 


DirectiveLocal ValueMaster Value
zlib.output_compressionOffOff
zlib.output_compression_level-1-1
zlib.output_handlerno valueno value

Additional Modules

Module Name

Environment

VariableValue
LANG en_US.UTF-8 
LC_ADDRESS sk_SK.UTF-8 
LC_IDENTIFICATION sk_SK.UTF-8 
LC_MEASUREMENT sk_SK.UTF-8 
LC_MONETARY sk_SK.UTF-8 
LC_NAME sk_SK.UTF-8 
LC_NUMERIC sk_SK.UTF-8 
LC_PAPER sk_SK.UTF-8 
LC_TELEPHONE sk_SK.UTF-8 
LC_TIME sk_SK.UTF-8 
PATH /usr/local/sbin:/usr/local/bin:/usr/bin 
USER root 
INVOCATION_ID 3a824b20bd4a4d70b2a91d418b186c81 
JOURNAL_STREAM 9:248954 
SYSTEMD_EXEC_PID 36336 
MEMORY_PRESSURE_WATCH /sys/fs/cgroup/system.slice/httpd.service/memory.pressure 
MEMORY_PRESSURE_WRITE c29tZSAyMDAwMDAgMjAwMDAwMAA= 

PHP Variables

VariableValue
$_COOKIE['PHPSESSID']19c0901bbe93a5a099d48aae84f5e40e
$_COOKIE['BOSON_SESSION']e47e7fa35dd23c3592205102c57902b4
$_SERVER['HTTP_HOST']localhost
$_SERVER['HTTP_USER_AGENT']Mozilla/5.0 (X11; Linux x86_64; rv:141.0) Gecko/20100101 Firefox/141.0
$_SERVER['HTTP_ACCEPT']text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
$_SERVER['HTTP_ACCEPT_LANGUAGE']en-US,en;q=0.5
$_SERVER['HTTP_ACCEPT_ENCODING']gzip, deflate, br, zstd
$_SERVER['HTTP_CONNECTION']keep-alive
$_SERVER['HTTP_COOKIE']PHPSESSID=19c0901bbe93a5a099d48aae84f5e40e; BOSON_SESSION=e47e7fa35dd23c3592205102c57902b4
$_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS']1
$_SERVER['HTTP_SEC_FETCH_DEST']document
$_SERVER['HTTP_SEC_FETCH_MODE']navigate
$_SERVER['HTTP_SEC_FETCH_SITE']none
$_SERVER['HTTP_SEC_FETCH_USER']?1
$_SERVER['HTTP_PRIORITY']u=0, i
$_SERVER['PATH']/usr/local/sbin:/usr/local/bin:/usr/bin
$_SERVER['SERVER_SIGNATURE']no value
$_SERVER['SERVER_SOFTWARE']Apache/2.4.63 (Unix) PHP/8.4.11
$_SERVER['SERVER_NAME']localhost
$_SERVER['SERVER_ADDR']127.0.0.1
$_SERVER['SERVER_PORT']80
$_SERVER['REMOTE_ADDR']127.0.0.1
$_SERVER['DOCUMENT_ROOT']/srv/http/minimal/public
$_SERVER['REQUEST_SCHEME']http
$_SERVER['CONTEXT_PREFIX']no value
$_SERVER['CONTEXT_DOCUMENT_ROOT']/srv/http/minimal/public
$_SERVER['SERVER_ADMIN']you@example.com
$_SERVER['SCRIPT_FILENAME']/srv/http/minimal/public/info-md.php
$_SERVER['REMOTE_PORT']51112
$_SERVER['GATEWAY_INTERFACE']CGI/1.1
$_SERVER['SERVER_PROTOCOL']HTTP/1.1
$_SERVER['REQUEST_METHOD']GET
$_SERVER['QUERY_STRING']no value
$_SERVER['REQUEST_URI']/info-md.php
$_SERVER['SCRIPT_NAME']/info-md.php
$_SERVER['PHP_SELF']/info-md.php
$_SERVER['REQUEST_TIME_FLOAT']1756406212.6653
$_SERVER['REQUEST_TIME']1756406212


PHP Credits

PHP Group
Thies C. Arntzen, Stig Bakken, Shane Caraveo, Andi Gutmans, Rasmus Lerdorf, Sam Ruby, Sascha Schumann, Zeev Suraski, Jim Winstead, Andrei Zmievski 


Language Design &amp; Concept
Andi Gutmans, Rasmus Lerdorf, Zeev Suraski, Marcus Boerger 


PHP Authors
ContributionAuthors
Zend Scripting Language Engine Andi Gutmans, Zeev Suraski, Stanislav Malyshev, Marcus Boerger, Dmitry Stogov, Xinchen Hui, Nikita Popov 
Extension Module API Andi Gutmans, Zeev Suraski, Andrei Zmievski 
UNIX Build and Modularization Stig Bakken, Sascha Schumann, Jani Taskinen, Peter Kokot 
Windows Support Shane Caraveo, Zeev Suraski, Wez Furlong, Pierre-Alain Joye, Anatol Belski, Kalle Sommer Nielsen 
Server API (SAPI) Abstraction Layer Andi Gutmans, Shane Caraveo, Zeev Suraski 
Streams Abstraction Layer Wez Furlong, Sara Golemon 
PHP Data Objects Layer Wez Furlong, Marcus Boerger, Sterling Hughes, George Schlossnagle, Ilia Alshanetsky 
Output Handler Zeev Suraski, Thies C. Arntzen, Marcus Boerger, Michael Wallner 
Consistent 64 bit support Anthony Ferrara, Anatol Belski 


SAPI Modules
ContributionAuthors
Apache 2 Handler Ian Holsman, Justin Erenkrantz (based on Apache 2 Filter code) 
CGI / FastCGI Rasmus Lerdorf, Stig Bakken, Shane Caraveo, Dmitry Stogov 
CLI Edin Kadribasic, Marcus Boerger, Johannes Schlueter, Moriyoshi Koizumi, Xinchen Hui 
Embed Edin Kadribasic 
FastCGI Process Manager Andrei Nigmatulin, dreamcat4, Antony Dovgal, Jerome Loyet 
litespeed George Wang 
phpdbg Felipe Pena, Joe Watkins, Bob Weinand 


Module Authors
ModuleAuthors
BC Math Andi Gutmans 
Bzip2 Sterling Hughes 
Calendar Shane Caraveo, Colin Viebrock, Hartmut Holzgraefe, Wez Furlong 
COM and .Net Wez Furlong 
ctype Hartmut Holzgraefe 
cURL Sterling Hughes 
Date/Time Support Derick Rethans 
DB-LIB (MS SQL, Sybase) Wez Furlong, Frank M. Kromann, Adam Baratz 
DBA Sascha Schumann, Marcus Boerger 
DOM Christian Stocker, Rob Richards, Marcus Boerger, Niels Dossche 
enchant Pierre-Alain Joye, Ilia Alshanetsky 
EXIF Rasmus Lerdorf, Marcus Boerger 
FFI Dmitry Stogov 
fileinfo Ilia Alshanetsky, Pierre Alain Joye, Scott MacVicar, Derick Rethans, Anatol Belski 
Firebird driver for PDO Ard Biesheuvel 
FTP Stefan Esser, Andrew Skalski 
GD imaging Rasmus Lerdorf, Stig Bakken, Jim Winstead, Jouni Ahto, Ilia Alshanetsky, Pierre-Alain Joye, Marcus Boerger, Mark Randall 
GetText Alex Plotnick 
GNU GMP support Stanislav Malyshev 
Iconv Rui Hirokawa, Stig Bakken, Moriyoshi Koizumi 
Input Filter Rasmus Lerdorf, Derick Rethans, Pierre-Alain Joye, Ilia Alshanetsky 
Internationalization Ed Batutis, Vladimir Iordanov, Dmitry Lakhtyuk, Stanislav Malyshev, Vadim Savchuk, Kirti Velankar 
JSON Jakub Zelenka, Omar Kilani, Scott MacVicar 
LDAP Amitay Isaacs, Eric Warnke, Rasmus Lerdorf, Gerrit Thomson, Stig Venaas 
LIBXML Christian Stocker, Rob Richards, Marcus Boerger, Wez Furlong, Shane Caraveo 
Multibyte String Functions Tsukada Takuya, Rui Hirokawa 
MySQL driver for PDO George Schlossnagle, Wez Furlong, Ilia Alshanetsky, Johannes Schlueter 
MySQLi Zak Greant, Georg Richter, Andrey Hristov, Ulf Wendel 
MySQLnd Andrey Hristov, Ulf Wendel, Georg Richter, Johannes Schlüter 
ODBC driver for PDO Wez Furlong 
ODBC Stig Bakken, Andreas Karajannis, Frank M. Kromann, Daniel R. Kalowsky 
Opcache Andi Gutmans, Zeev Suraski, Stanislav Malyshev, Dmitry Stogov, Xinchen Hui 
OpenSSL Stig Venaas, Wez Furlong, Sascha Kettler, Scott MacVicar, Eliot Lear 
pcntl Jason Greene, Arnaud Le Blanc 
Perl Compatible Regexps Andrei Zmievski 
PHP Archive Gregory Beaver, Marcus Boerger 
PHP Data Objects Wez Furlong, Marcus Boerger, Sterling Hughes, George Schlossnagle, Ilia Alshanetsky 
PHP hash Sara Golemon, Rasmus Lerdorf, Stefan Esser, Michael Wallner, Scott MacVicar 
Posix Kristian Koehntopp 
PostgreSQL driver for PDO Edin Kadribasic, Ilia Alshanetsky 
PostgreSQL Jouni Ahto, Zeev Suraski, Yasuo Ohgaki, Chris Kings-Lynne 
random Go Kudo, Tim Düsterhus, Guilliam Xavier, Christoph M. Becker, Jakub Zelenka, Bob Weinand, Máté Kocsis, and Original RNG implementators 
Readline Thies C. Arntzen 
Reflection Marcus Boerger, Timm Friebe, George Schlossnagle, Andrei Zmievski, Johannes Schlueter 
Sessions Sascha Schumann, Andrei Zmievski 
Shared Memory Operations Slava Poliakov, Ilia Alshanetsky 
SimpleXML Sterling Hughes, Marcus Boerger, Rob Richards 
SNMP Rasmus Lerdorf, Harrie Hazewinkel, Mike Jackson, Steven Lawrance, Johann Hanne, Boris Lytochkin 
SOAP Brad Lafountain, Shane Caraveo, Dmitry Stogov 
Sockets Chris Vandomelen, Sterling Hughes, Daniel Beulshausen, Jason Greene 
Sodium Frank Denis 
SPL Marcus Boerger, Etienne Kneuss 
SQLite 3.x driver for PDO Wez Furlong 
SQLite3 Scott MacVicar, Ilia Alshanetsky, Brad Dewar 
System V Message based IPC Wez Furlong 
System V Semaphores Tom May 
System V Shared Memory Christian Cartus 
tidy John Coggeshall, Ilia Alshanetsky 
tokenizer Andrei Zmievski, Johannes Schlueter 
XML Stig Bakken, Thies C. Arntzen, Sterling Hughes 
XMLReader Rob Richards 
XMLWriter Rob Richards, Pierre-Alain Joye 
XSL Christian Stocker, Rob Richards 
Zip Pierre-Alain Joye, Remi Collet 
Zlib Rasmus Lerdorf, Stefan Roehrich, Zeev Suraski, Jade Nicoletti, Michael Wallner 


PHP Documentation
Authors Mehdi Achour, Friedhelm Betz, Antony Dovgal, Nuno Lopes, Hannes Magnusson, Philip Olson, Georg Richter, Damien Seguy, Jakub Vrana, Adam Harvey 
Editor Peter Cowburn 
User Note Maintainers Daniel P. Brown, Thiago Henrique Pojda 
Other Contributors Previously active authors, editors and other contributors are listed in the manual. 


PHP Quality Assurance Team
Ilia Alshanetsky, Joerg Behrens, Antony Dovgal, Stefan Esser, Moriyoshi Koizumi, Magnus Maatta, Sebastian Nohn, Derick Rethans, Melvyn Sopacua, Pierre-Alain Joye, Dmitry Stogov, Felipe Pena, David Soria Parra, Stanislav Malyshev, Julien Pauli, Stephen Zarkos, Anatol Belski, Remi Collet, Ferenc Kovacs 


Websites and Infrastructure team
PHP Websites Team Rasmus Lerdorf, Hannes Magnusson, Philip Olson, Lukas Kahwe Smith, Pierre-Alain Joye, Kalle Sommer Nielsen, Peter Cowburn, Adam Harvey, Ferenc Kovacs, Levi Morrison 
Event Maintainers Damien Seguy, Daniel P. Brown 
Network Infrastructure Daniel P. Brown 
Windows Infrastructure Alex Schoenmaker 

PHP License



This program is free software; you can redistribute it and/or modify it under the terms of the PHP License as published by the PHP Group and included in the distribution in the file:  LICENSE

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

If you did not receive a copy of the PHP license, or have any questions about PHP licensing, please contact license@php.net.




```