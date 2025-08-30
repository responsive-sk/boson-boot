# PHP Info Report

**Generated:** 2025-08-28 20:38:51

## System Information

- PHP Version: 8.4.11
- OS: Linux
- Server: Apache## Full phpinfo()

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



System Linux cloud0001 4.9.337 #1 SMP Thu Feb 29 19:59:04 CET 2024 x86_64 
Build Date Aug  3 2025 08:46:38 
Build System Linux 
Build Provider Debian 
Server API FPM/FastCGI 
Virtual Directory Support disabled 
Configuration File (php.ini) Path /etc/php/8.4/fpm 
Loaded Configuration File /etc/php/8.4/fpm/php.ini 
Scan this dir for additional .ini files /etc/php/8.4/fpm/conf.d 
Additional .ini files parsed /etc/php/8.4/fpm/conf.d/10-mysqlnd.ini,
/etc/php/8.4/fpm/conf.d/10-opcache.ini,
/etc/php/8.4/fpm/conf.d/10-pdo.ini,
/etc/php/8.4/fpm/conf.d/15-xml.ini,
/etc/php/8.4/fpm/conf.d/20-bcmath.ini,
/etc/php/8.4/fpm/conf.d/20-bz2.ini,
/etc/php/8.4/fpm/conf.d/20-calendar.ini,
/etc/php/8.4/fpm/conf.d/20-ctype.ini,
/etc/php/8.4/fpm/conf.d/20-curl.ini,
/etc/php/8.4/fpm/conf.d/20-dom.ini,
/etc/php/8.4/fpm/conf.d/20-exif.ini,
/etc/php/8.4/fpm/conf.d/20-ffi.ini,
/etc/php/8.4/fpm/conf.d/20-fileinfo.ini,
/etc/php/8.4/fpm/conf.d/20-ftp.ini,
/etc/php/8.4/fpm/conf.d/20-gd.ini,
/etc/php/8.4/fpm/conf.d/20-gettext.ini,
/etc/php/8.4/fpm/conf.d/20-iconv.ini,
/etc/php/8.4/fpm/conf.d/20-igbinary.ini,
/etc/php/8.4/fpm/conf.d/20-imagick.ini,
/etc/php/8.4/fpm/conf.d/20-imap.ini,
/etc/php/8.4/fpm/conf.d/20-intl.ini,
/etc/php/8.4/fpm/conf.d/20-mbstring.ini,
/etc/php/8.4/fpm/conf.d/20-msgpack.ini,
/etc/php/8.4/fpm/conf.d/20-mysqli.ini,
/etc/php/8.4/fpm/conf.d/20-pdo_mysql.ini,
/etc/php/8.4/fpm/conf.d/20-pdo_sqlite.ini,
/etc/php/8.4/fpm/conf.d/20-phar.ini,
/etc/php/8.4/fpm/conf.d/20-posix.ini,
/etc/php/8.4/fpm/conf.d/20-readline.ini,
/etc/php/8.4/fpm/conf.d/20-realpath_turbo.ini,
/etc/php/8.4/fpm/conf.d/20-shmop.ini,
/etc/php/8.4/fpm/conf.d/20-simplexml.ini,
/etc/php/8.4/fpm/conf.d/20-soap.ini,
/etc/php/8.4/fpm/conf.d/20-sockets.ini,
/etc/php/8.4/fpm/conf.d/20-sqlite3.ini,
/etc/php/8.4/fpm/conf.d/20-sysvmsg.ini,
/etc/php/8.4/fpm/conf.d/20-sysvsem.ini,
/etc/php/8.4/fpm/conf.d/20-sysvshm.ini,
/etc/php/8.4/fpm/conf.d/20-tidy.ini,
/etc/php/8.4/fpm/conf.d/20-tokenizer.ini,
/etc/php/8.4/fpm/conf.d/20-xmlreader.ini,
/etc/php/8.4/fpm/conf.d/20-xmlrpc.ini,
/etc/php/8.4/fpm/conf.d/20-xmlwriter.ini,
/etc/php/8.4/fpm/conf.d/20-xsl.ini,
/etc/php/8.4/fpm/conf.d/20-zip.ini,
/etc/php/8.4/fpm/conf.d/25-memcached.ini
 
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
Registered PHP Streamshttps, ftps, compress.zlib, php, file, glob, data, http, ftp, compress.bzip2, phar, zip
Registered Stream Socket Transportstcp, udp, unix, udg, ssl, tls, tlsv1.0, tlsv1.1, tlsv1.2, tlsv1.3
Registered Stream Filterszlib.*, string.rot13, string.toupper, string.tolower, convert.*, consumed, dechunk, bzip2.*, convert.iconv.*




This program makes use of the Zend Scripting Language Engine:Zend Engine v4.4.11, Copyright (c) Zend Technologies
    with Zend OPcache v8.4.11, Copyright (c), by Zend Technologies



Configuration
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

cgi-fcgi

php-fpm active 


DirectiveLocal ValueMaster Value
cgi.discard_pathOffOff
cgi.fix_pathinfoOnOn
cgi.force_redirectOnOn
cgi.nphOffOff
cgi.redirect_status_envno valueno value
cgi.rfc2616_headersOffOff
fastcgi.error_headerno valueno value
fastcgi.loggingOnOn
fpm.configno valueno value

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
browscap/etc/php/browscap.ini/etc/php/browscap.ini
default_charsetUTF-8UTF-8
default_mimetypetext/htmltext/html
disable_classesno valueno value
disable_functionslink,symlink,dl,syslog,openlog,symlink,disk_free_space,diskfreespacedl,syslog,openlog,symlink,disk_free_space,diskfreespace
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
error_reporting2251722517
expose_phpOffOff
extension_dir/usr/lib/php/20240924/usr/lib/php/20240924
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
include_path.:/usr/share/php:/usr/share/php/PEAR.:/usr/share/php:/usr/share/php/PEAR
input_encodingno valueno value
internal_encodingno valueno value
log_errorsOnOn
mail.add_x_headerOnOn
mail.force_extra_parametersno valueno value
mail.log/var/log/php/mail.log/var/log/php/mail.log
mail.mixed_lf_and_crlfOffOff
max_execution_time500500
max_file_uploads2020
max_input_nesting_level6464
max_input_time500500
max_input_vars1000010000
max_multipart_body_parts-1-1
memory_limit500M500M
open_basedir/home/resp/sub/test/:/home/resp/.inetadmin-php-tmp:/tmp/:/home/_tmp/:/usr/share/php/:/dev/random:/dev/urandom:/etc/php/user_settings/:/var/www/opcache/firewall_resolve_fp.phpno value
output_bufferingno valueno value
output_encodingno valueno value
output_handlerno valueno value
post_max_size500M500M
precision1212
realpath_cache_size4096K4096K
realpath_cache_ttl600600
register_argc_argvOnOn
report_memleaksOnOn
report_zend_debugOffOff
request_orderno valueno value
sendmail_fromno valueno value
sendmail_path/etc/php/sendmail.py/etc/php/sendmail.py
serialize_precision100100
short_open_tagOnOn
SMTPlocalhostlocalhost
smtp_port2525
sys_temp_dir/home/resp/.inetadmin-php-tmp/home/resp/.inetadmin-php-tmp
syslog.facilityLOG_USERLOG_USER
syslog.filterno-ctrlno-ctrl
syslog.identphpphp
unserialize_callback_funcno valueno value
upload_max_filesize500M500M
upload_tmp_dir/home/resp/.inetadmin-php-tmp/home/resp/.inetadmin-php-tmp
user_dirno valueno value
user_ini.cache_ttl300300
user_ini.filename.user.ini.user.ini
variables_orderEGPCSEGPCS
xmlrpc_error_number00
xmlrpc_errorsOffOff
zend.assertions11
zend.detect_unicodeOnOn
zend.enable_gcOnOn
zend.exception_ignore_argsOffOff
zend.exception_string_param_max_len1515
zend.max_allowed_stack_size00
zend.multibyteOffOff
zend.reserved_stack_size00
zend.script_encodingno valueno value
zend.signal_checkOffOff

ctype

ctype functions enabled 

curl

cURL support enabled 
cURL Information 7.74.0 
Age 7 
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
NTLMWB Yes 
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
HTTP3 No 
UNICODE No 
ZSTD No 
HSTS No 
Protocols dict, file, ftp, ftps, gopher, http, https, imap, imaps, ldap, ldaps, mqtt, pop3, pop3s, rtmp, rtsp, scp, sftp, smb, smbs, smtp, smtps, telnet, tftp 
Host x86_64-pc-linux-gnu 
SSL Version OpenSSL/1.1.1w 
ZLib Version 1.2.11 
libSSH Version libssh2/1.9.0 


DirectiveLocal ValueMaster Value
curl.cainfono valueno value

date

date/time support enabled 
timelib version 2022.12 
&quot;Olson&quot; Timezone Database Version 0.system 
Timezone Database internal 
Default timezone Europe/Bratislava 


DirectiveLocal ValueMaster Value
date.default_latitude31.766731.7667
date.default_longitude35.233335.2333
date.sunrise_zenith90.83333390.833333
date.sunset_zenith90.83333390.833333
date.timezoneEurope/BratislavaEurope/Bratislava

dom

DOM/XML enabled 
DOM/XML API Version 20031129 
libxml Version 2.9.14 
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

FFI

FFI support enabled 


DirectiveLocal ValueMaster Value
ffi.enablepreloadpreload
ffi.preloadno valueno value

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

hash

hash support enabled 
Hashing Engines md2 md4 md5 sha1 sha224 sha256 sha384 sha512/224 sha512/256 sha512 sha3-224 sha3-256 sha3-384 sha3-512 ripemd128 ripemd160 ripemd256 ripemd320 whirlpool tiger128,3 tiger160,3 tiger192,3 tiger128,4 tiger160,4 tiger192,4 snefru snefru256 gost gost-crypto adler32 crc32 crc32b crc32c fnv132 fnv1a32 fnv164 fnv1a64 joaat murmur3a murmur3c murmur3f xxh32 xxh64 xxh3 xxh128 haval128,3 haval160,3 haval192,3 haval224,3 haval256,3 haval128,4 haval160,4 haval192,4 haval224,4 haval256,4 haval128,5 haval160,5 haval192,5 haval224,5 haval256,5  


MHASH support Enabled 
MHASH API Version Emulated Support 

iconv

iconv support enabled 
iconv implementation glibc 
iconv library version 2.31 


DirectiveLocal ValueMaster Value
iconv.input_encodingno valueno value
iconv.internal_encodingno valueno value
iconv.output_encodingno valueno value

igbinary

igbinary support enabled 
igbinary version 3.2.16 
igbinary APCu serializer ABI 0 
igbinary session support yes 


DirectiveLocal ValueMaster Value
igbinary.compact_stringsOnOn

imagick

imagick moduleenabled
imagick module version 3.8.0 
imagick classes Imagick, ImagickDraw, ImagickPixel, ImagickPixelIterator, ImagickKernel 
Imagick compiled with ImageMagick version ImageMagick 6.9.11-60 Q16 x86_64 2021-01-25 https://imagemagick.org 
Imagick using ImageMagick library version ImageMagick 6.9.11-60 Q16 x86_64 2021-01-25 https://imagemagick.org 
ImageMagick copyright (C) 1999-2021 ImageMagick Studio LLC 
ImageMagick release date 2021-01-25 
ImageMagick number of supported formats:  247 
ImageMagick supported formats 3FR, 3G2, 3GP, AAI, AI, APNG, ART, ARW, AVI, AVIF, AVS, BGR, BGRA, BGRO, BIE, BMP, BMP2, BMP3, BRF, CAL, CALS, CANVAS, CAPTION, CIN, CIP, CLIP, CMYK, CMYKA, CR2, CR3, CRW, CUR, CUT, DATA, DCM, DCR, DCX, DDS, DFONT, DJVU, DNG, DOT, DPX, DXT1, DXT5, EPDF, EPI, EPS, EPS2, EPS3, EPSF, EPSI, EPT, EPT2, EPT3, ERF, EXR, FAX, FILE, FITS, FRACTAL, FTP, FTS, G3, G4, GIF, GIF87, GRADIENT, GRAY, GRAYA, GROUP4, GV, H, HALD, HDR, HEIC, HISTOGRAM, HRZ, HTM, HTML, HTTP, HTTPS, ICB, ICO, ICON, IIQ, INFO, INLINE, IPL, ISOBRL, ISOBRL6, J2C, J2K, JBG, JBIG, JNG, JNX, JP2, JPC, JPE, JPEG, JPG, JPM, JPS, JPT, JSON, K25, KDC, LABEL, M2V, M4V, MAC, MAGICK, MAP, MASK, MAT, MATTE, MEF, MIFF, MKV, MNG, MONO, MOV, MP4, MPC, MPG, MRW, MSL, MSVG, MTV, MVG, NEF, NRW, NULL, ORF, OTB, OTF, PAL, PALM, PAM, PANGO, PATTERN, PBM, PCD, PCDS, PCL, PCT, PCX, PDB, PDF, PDFA, PEF, PES, PFA, PFB, PFM, PGM, PGX, PICON, PICT, PIX, PJPEG, PLASMA, PNG, PNG00, PNG24, PNG32, PNG48, PNG64, PNG8, PNM, POCKETMOD, PPM, PREVIEW, PS, PS2, PS3, PSB, PSD, PTIF, PWP, RADIAL-GRADIENT, RAF, RAS, RAW, RGB, RGBA, RGBO, RGF, RLA, RLE, RMF, RW2, SCR, SCT, SFW, SGI, SHTML, SIX, SIXEL, SPARSE-COLOR, SR2, SRF, STEGANO, SUN, SVG, SVGZ, TEXT, TGA, THUMBNAIL, TIFF, TIFF64, TILE, TIM, TTC, TTF, TXT, UBRL, UBRL6, UIL, UYVY, VDA, VICAR, VID, VIDEO, VIFF, VIPS, VST, WBMP, WEBM, WEBP, WMF, WMV, WMZ, WPG, X, X3F, XBM, XC, XCF, XPM, XPS, XV, XWD, YCbCr, YCbCrA, YUV 


DirectiveLocal ValueMaster Value
imagick.allow_zero_dimension_images00
imagick.locale_fix00
imagick.progress_monitor00
imagick.set_single_thread11
imagick.shutdown_sleep_count1010
imagick.skip_version_check11

imap

IMAP extension Version 1.0.3 
IMAP c-Client Version 2007f 
SSL Support enabled 
Kerberos Support enabled 


DirectiveLocal ValueMaster Value
imap.enable_insecure_rshOffOff

intl

Internationalization support enabled 
ICU version 67.1 
ICU Data version 67.1 
ICU TZData version 2019c 
ICU Unicode version 13.0 


DirectiveLocal ValueMaster Value
intl.default_localeno valueno value
intl.error_level00
intl.use_exceptionsOffOff

json

json support enabled 

libxml

libXML support active 
libXML Compiled Version 2.9.14 
libXML Loaded Version 20914 
libXML streams enabled 

mbstring

Multibyte Support enabled 
Multibyte string engine libmbfl 
HTTP input encoding translation disabled 
libmbfl version 1.3.2 


mbstring extension makes use of "streamable kanji code filter and converter", which is distributed under the GNU Lesser General Public License version 2.1.


Multibyte (japanese) regex support enabled 
Multibyte regex (oniguruma) version 6.9.6 


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

memcached

memcached supportenabled
Version 3.3.0 
libmemcached-awesome version 1.1.4 
SASL support yes 
Session support yes 
igbinary support yes 
json support yes 
msgpack support yes 
zstd support no 


DirectiveLocal ValueMaster Value
memcached.compression_factor1.31.3
memcached.compression_level33
memcached.compression_threshold20002000
memcached.compression_typefastlzfastlz
memcached.default_binary_protocolOffOff
memcached.default_connect_timeout00
memcached.default_consistent_hashOffOff
memcached.item_size_limit00
memcached.serializerigbinaryigbinary
memcached.sess_binary_protocolOnOn
memcached.sess_connect_timeout00
memcached.sess_consistent_hashOnOn
memcached.sess_consistent_hash_typeketamaketama
memcached.sess_lock_expire00
memcached.sess_lock_max_waitnot setnot set
memcached.sess_lock_retries55
memcached.sess_lock_waitnot setnot set
memcached.sess_lock_wait_max150150
memcached.sess_lock_wait_min150150
memcached.sess_lockingOnOn
memcached.sess_number_of_replicas00
memcached.sess_persistentOffOff
memcached.sess_prefixmemc.sess.key.memc.sess.key.
memcached.sess_randomize_replica_readOffOff
memcached.sess_remove_failed_serversOffOff
memcached.sess_sasl_passwordno valueno value
memcached.sess_sasl_usernameno valueno value
memcached.sess_server_failure_limit00
memcached.store_retry_count00

msgpack

MessagePack Support enabled 
Session Support enabled 
MessagePack APCu Serializer ABI no 
extension Version 3.0.0 
header Version 3.2.0 


DirectiveLocal ValueMaster Value
msgpack.assocOnOn
msgpack.error_displayOnOn
msgpack.illegal_key_insertOffOff
msgpack.php_onlyOnOn
msgpack.use_str8_serializationOnOn

mysqli

MysqlI Support enabled 
Client API library version mysqlnd 8.4.11 
Active Persistent Links 0 
Inactive Persistent Links 0 
Active Links 0 


DirectiveLocal ValueMaster Value
mysqli.allow_local_infileOffOff
mysqli.allow_persistentOnOn
mysqli.default_hostlocalhostlocalhost
mysqli.default_port33063306
mysqli.default_pwno valueno value
mysqli.default_socket/var/run/mysqld/mysqld.sock/var/run/mysqld/mysqld.sock
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
OpenSSL Library Version OpenSSL 1.1.1w  11 Sep 2023 
OpenSSL Header Version OpenSSL 1.1.1w  11 Sep 2023 
Openssl default config /usr/lib/ssl/openssl.cnf 


DirectiveLocal ValueMaster Value
openssl.cafileno valueno value
openssl.capathno valueno value

pcre

PCRE (Perl Compatible Regular Expressions) Support enabled 
PCRE Library Version 10.40 2022-04-14 
PCRE Unicode Version 14.0.0 
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
pdo_mysql.default_socket/var/run/mysqld/mysqld.sock/var/run/mysqld/mysqld.sock

pdo_sqlite

PDO Driver for SQLite 3.x enabled 
SQLite Library 3.34.1 

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

readline

Readline Support enabled 
Readline library EditLine wrapper 


DirectiveLocal ValueMaster Value
cli.pagerno valueno value
cli.prompt\b \&gt; \b \&gt; 

realpath_turbo

realpath_turbo supportenabled
Version 2.0.0 
Build Date Nov 23 2024 19:43:35 
Creator Artur Graniszewski 


DirectiveLocal ValueMaster Value
realpath_turbo.disable_dangerous_functionsOnOn
realpath_turbo.open_basedir/home/resp/sub/test/:/home/resp/.inetadmin-php-tmp:/tmp/:/home/_tmp/:/usr/share/php/:/dev/random:/dev/urandom:/etc/php/user_settings/:/var/www/opcache/firewall_resolve_fp.php/home/resp/sub/test/:/home/resp/.inetadmin-php-tmp:/tmp/:/home/_tmp/:/usr/share/php/:/dev/random:/dev/urandom:/etc/php/user_settings/:/var/www/opcache/firewall_resolve_fp.php

Reflection

Reflection enabled 

session

Session Support enabled 
Registered save handlers files user memcached  
Registered serializer handlers php_serialize php php_binary igbinary msgpack  


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
session.gc_divisor100100
session.gc_maxlifetime36003600
session.gc_probability00
session.lazy_writeOnOn
session.namePHPSESSIDPHPSESSID
session.referer_checkno valueno value
session.save_handlerfilesfiles
session.save_path/var/lib/php/sessions/var/lib/php/sessions
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

shmop

shmop support enabled 

SimpleXML

SimpleXML support enabled 
Schema support enabled 

soap

Soap Client enabled 
Soap Server enabled 


DirectiveLocal ValueMaster Value
soap.wsdl_cache11
soap.wsdl_cache_dir/home/resp/.inetadmin-php-tmp/home/resp/.inetadmin-php-tmp
soap.wsdl_cache_enabledOffOff
soap.wsdl_cache_limit55
soap.wsdl_cache_ttl8640086400

sockets

Sockets Support enabled 

sodium

sodium support enabled 
libsodium headers version 1.0.18 
libsodium library version 1.0.18 

SPL

SPL support enabled 
Interfaces OuterIterator, RecursiveIterator, SeekableIterator, SplObserver, SplSubject 
Classes AppendIterator, ArrayIterator, ArrayObject, BadFunctionCallException, BadMethodCallException, CachingIterator, CallbackFilterIterator, DirectoryIterator, DomainException, EmptyIterator, FilesystemIterator, FilterIterator, GlobIterator, InfiniteIterator, InvalidArgumentException, IteratorIterator, LengthException, LimitIterator, LogicException, MultipleIterator, NoRewindIterator, OutOfBoundsException, OutOfRangeException, OverflowException, ParentIterator, RangeException, RecursiveArrayIterator, RecursiveCachingIterator, RecursiveCallbackFilterIterator, RecursiveDirectoryIterator, RecursiveFilterIterator, RecursiveIteratorIterator, RecursiveRegexIterator, RecursiveTreeIterator, RegexIterator, RuntimeException, SplDoublyLinkedList, SplFileInfo, SplFileObject, SplFixedArray, SplHeap, SplMinHeap, SplMaxHeap, SplObjectStorage, SplPriorityQueue, SplQueue, SplStack, SplTempFileObject, UnderflowException, UnexpectedValueException 

sqlite3

SQLite3 support enabled 
SQLite Library 3.34.1 


DirectiveLocal ValueMaster Value
sqlite3.defensiveOnOn
sqlite3.extension_dirno valueno value

standard

Dynamic Library Support enabled 
Path to sendmail /etc/php/sendmail.py 


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
url_rewriter.tagsa=href,area=href,frame=src,input=src,form=,fieldset=a=href,area=href,frame=src,input=src,form=,fieldset=
user_agentno valueno value

sysvmsg

sysvmsg support enabled 

sysvsem

sysvsem support enabled 

sysvshm

sysvshm support enabled 

tidy

Tidy support enabled 
libTidy Version 5.6.0 
libTidy Release 2017/11/25 


DirectiveLocal ValueMaster Value
tidy.clean_outputOffOff
tidy.default_configno valueno value

tokenizer

Tokenizer Support enabled 

xml

XML Support active 
XML Namespace Support active 
libxml2 Version 2.9.14 

xmlreader

XMLReader enabled 

xmlrpc

XMLRPC extension version 1.0.0RC3 
core library version xmlrpc-epi v. 0.54 
author Dan Libby 
homepage http://xmlrpc-epi.sourceforge.net 
open sourced by Epinions.com 

xmlwriter

XMLWriter enabled 

xsl

XSL enabled 
libxslt Version 1.1.34 
libxslt compiled against libxml Version 2.9.10 
EXSLT enabled 
libexslt Version 1.1.34 

Zend OPcache

Opcode Caching Up and Running 
Optimization Enabled 
SHM Cache Enabled 
File Cache Enabled 
JIT Off 
Startup OK 
Shared memory model mmap 
Cache hits 1379608 
Cache misses 4201 
Used memory 145317944 
Free memory 109824048 
Wasted memory 7002008 
Interned Strings Used memory 24379536 
Interned Strings Free memory 9174896 
Cached scripts 4014 
Cached keys 5045 
Max keys 16229 
OOM restarts 0 
Hash keys restarts 0 
Manual restarts 0 
Start time 2025-08-26T21:40:02+0200 
Last restart time none 
Last force restart time none 


DirectiveLocal ValueMaster Value
opcache.blacklist_filenameno valueno value
opcache.dups_fixOffOff
opcache.enableOnOn
opcache.enable_cliOffOff
opcache.enable_file_overrideOnOn
opcache.error_logno valueno value
opcache.file_cache/home/resp/.inetadmin-php-opcache/home/resp/.inetadmin-php-opcache
opcache.file_cache_consistency_checksOffOff
opcache.file_cache_onlyOffOff
opcache.file_update_protection22
opcache.force_restart_timeout180180
opcache.huge_code_pagesOnOn
opcache.interned_strings_buffer3232
opcache.jitno valueno value
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
opcache.max_accelerated_files1622916229
opcache.max_file_size00
opcache.max_wasted_percentage55
opcache.memory_consumption250250
opcache.opt_debug_level00
opcache.optimization_level0x7FFEBFFF0x7FFEBFFF
opcache.preferred_memory_modelno valueno value
opcache.preloadno valueno value
opcache.preload_userno valueno value
opcache.protect_memoryOffOff
opcache.record_warningsOffOff
opcache.restrict_api/var/www/opcache//var/www/opcache/
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
Libzip version 1.7.3 
BZIP2 compression Yes 
XZ compression No 
ZSTD compression No 
AES-128 encryption Yes 
AES-192 encryption Yes 
AES-256 encryption Yes 

zlib

ZLib Support enabled 
Stream Wrapper compress.zlib:// 
Stream Filter zlib.inflate, zlib.deflate 
Compiled Version 1.2.11 
Linked Version 1.2.11 


DirectiveLocal ValueMaster Value
zlib.output_compressionOffOff
zlib.output_compression_level-1-1
zlib.output_handlerno valueno value

Additional Modules

Module Name

Environment

VariableValue

PHP Variables

VariableValue
$_REQUEST['PHPSESSID']510cdecf9a0f3b40160b1459563bbb90
$_REQUEST['BOSON_SESSION']619e014e07382ccf8f9057f790e7eb98
$_COOKIE['PHPSESSID']510cdecf9a0f3b40160b1459563bbb90
$_COOKIE['BOSON_SESSION']619e014e07382ccf8f9057f790e7eb98
$_SERVER['PHP_ADMIN_VALUE']realpath_turbo.open_basedir=&#039;/home/resp/sub/test/:/home/resp/.inetadmin-php-tmp:/tmp/:/home/_tmp/:/usr/share/php/:/dev/random:/dev/urandom:/etc/php/user_settings/:/var/www/opcache/firewall_resolve_fp.php&#039; 
 opcache.file_cache=/home/resp/.inetadmin-php-opcache
$_SERVER['SCRIPT_NAME']/info-md.php
$_SERVER['REQUEST_URI']/info-md.php
$_SERVER['QUERY_STRING']no value
$_SERVER['REQUEST_METHOD']GET
$_SERVER['SERVER_PROTOCOL']HTTP/2.0
$_SERVER['GATEWAY_INTERFACE']CGI/1.1
$_SERVER['REMOTE_PORT']43780
$_SERVER['SCRIPT_FILENAME']/home/resp/sub/test/public/info-md.php
$_SERVER['SERVER_ADMIN'][no address given]
$_SERVER['CONTEXT_DOCUMENT_ROOT']/home/resp/sub/test/public/
$_SERVER['CONTEXT_PREFIX']no value
$_SERVER['REQUEST_SCHEME']https
$_SERVER['DOCUMENT_ROOT']/home/resp/sub/test/public/
$_SERVER['REMOTE_ADDR']185.254.248.213
$_SERVER['SERVER_PORT']443
$_SERVER['SERVER_ADDR']10.10.200.12
$_SERVER['SERVER_NAME']test.responsive.sk
$_SERVER['SERVER_SOFTWARE']Apache
$_SERVER['SERVER_SIGNATURE']no value
$_SERVER['PATH']/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
$_SERVER['HTTP_HOST']test.responsive.sk
$_SERVER['HTTP_TE']trailers
$_SERVER['HTTP_PRIORITY']u=0, i
$_SERVER['HTTP_SEC_FETCH_USER']?1
$_SERVER['HTTP_SEC_FETCH_SITE']none
$_SERVER['HTTP_SEC_FETCH_MODE']navigate
$_SERVER['HTTP_SEC_FETCH_DEST']document
$_SERVER['HTTP_COOKIE']PHPSESSID=510cdecf9a0f3b40160b1459563bbb90; BOSON_SESSION=619e014e07382ccf8f9057f790e7eb98
$_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS']1
$_SERVER['HTTP_ACCEPT_ENCODING']gzip, deflate, br, zstd
$_SERVER['HTTP_ACCEPT_LANGUAGE']en-US,en;q=0.5
$_SERVER['HTTP_ACCEPT']text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
$_SERVER['HTTP_USER_AGENT']Mozilla/5.0 (X11; Linux x86_64; rv:141.0) Gecko/20100101 Firefox/141.0
$_SERVER['proxy-nokeepalive']1
$_SERVER['SSL_TLS_SNI']test.responsive.sk
$_SERVER['HTTPS']on
$_SERVER['H2_STREAM_TAG']59996-630-3
$_SERVER['H2_STREAM_ID']3
$_SERVER['H2_PUSHED_ON']no value
$_SERVER['H2_PUSHED']no value
$_SERVER['H2_PUSH']off
$_SERVER['H2PUSH']off
$_SERVER['HTTP2']on
$_SERVER['AllowCountry']1
$_SERVER['GEOIP_COUNTRY_CODE']SK
$_SERVER['GEOIP_COUNTRY_NAME']Slovakia
$_SERVER['GEOIP_CONTINENT_CODE']EU
$_SERVER['GEOIP_CITY_NAME']Liptovský Hrádok
$_SERVER['MMDB_INFO']result found
$_SERVER['MMDB_ADDR']185.254.248.213
$_SERVER['UNIQUE_ID']aLCiOtyt8lyDebzuqil29QAHCAI
$_SERVER['FCGI_ROLE']RESPONDER
$_SERVER['PHP_SELF']/info-md.php
$_SERVER['REQUEST_TIME_FLOAT']1756406330.99
$_SERVER['REQUEST_TIME']1756406330
$_SERVER['argv']Array
(
)

$_SERVER['argc']0
$_ENV['PHP_ADMIN_VALUE']realpath_turbo.open_basedir=&#039;/home/resp/sub/test/:/home/resp/.inetadmin-php-tmp:/tmp/:/home/_tmp/:/usr/share/php/:/dev/random:/dev/urandom:/etc/php/user_settings/:/var/www/opcache/firewall_resolve_fp.php&#039; 
 opcache.file_cache=/home/resp/.inetadmin-php-opcache
$_ENV['SCRIPT_NAME']/info-md.php
$_ENV['REQUEST_URI']/info-md.php
$_ENV['QUERY_STRING']no value
$_ENV['REQUEST_METHOD']GET
$_ENV['SERVER_PROTOCOL']HTTP/2.0
$_ENV['GATEWAY_INTERFACE']CGI/1.1
$_ENV['REMOTE_PORT']43780
$_ENV['SCRIPT_FILENAME']/home/resp/sub/test/public/info-md.php
$_ENV['SERVER_ADMIN'][no address given]
$_ENV['CONTEXT_DOCUMENT_ROOT']/home/resp/sub/test/public/
$_ENV['CONTEXT_PREFIX']no value
$_ENV['REQUEST_SCHEME']https
$_ENV['DOCUMENT_ROOT']/home/resp/sub/test/public/
$_ENV['REMOTE_ADDR']185.254.248.213
$_ENV['SERVER_PORT']443
$_ENV['SERVER_ADDR']10.10.200.12
$_ENV['SERVER_NAME']test.responsive.sk
$_ENV['SERVER_SOFTWARE']Apache
$_ENV['SERVER_SIGNATURE']no value
$_ENV['PATH']/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin
$_ENV['HTTP_HOST']test.responsive.sk
$_ENV['HTTP_TE']trailers
$_ENV['HTTP_PRIORITY']u=0, i
$_ENV['HTTP_SEC_FETCH_USER']?1
$_ENV['HTTP_SEC_FETCH_SITE']none
$_ENV['HTTP_SEC_FETCH_MODE']navigate
$_ENV['HTTP_SEC_FETCH_DEST']document
$_ENV['HTTP_COOKIE']PHPSESSID=510cdecf9a0f3b40160b1459563bbb90; BOSON_SESSION=619e014e07382ccf8f9057f790e7eb98
$_ENV['HTTP_UPGRADE_INSECURE_REQUESTS']1
$_ENV['HTTP_ACCEPT_ENCODING']gzip, deflate, br, zstd
$_ENV['HTTP_ACCEPT_LANGUAGE']en-US,en;q=0.5
$_ENV['HTTP_ACCEPT']text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
$_ENV['HTTP_USER_AGENT']Mozilla/5.0 (X11; Linux x86_64; rv:141.0) Gecko/20100101 Firefox/141.0
$_ENV['proxy-nokeepalive']1
$_ENV['SSL_TLS_SNI']test.responsive.sk
$_ENV['HTTPS']on
$_ENV['H2_STREAM_TAG']59996-630-3
$_ENV['H2_STREAM_ID']3
$_ENV['H2_PUSHED_ON']no value
$_ENV['H2_PUSHED']no value
$_ENV['H2_PUSH']off
$_ENV['H2PUSH']off
$_ENV['HTTP2']on
$_ENV['AllowCountry']1
$_ENV['GEOIP_COUNTRY_CODE']SK
$_ENV['GEOIP_COUNTRY_NAME']Slovakia
$_ENV['GEOIP_CONTINENT_CODE']EU
$_ENV['GEOIP_CITY_NAME']Liptovský Hrádok
$_ENV['MMDB_INFO']result found
$_ENV['MMDB_ADDR']185.254.248.213
$_ENV['UNIQUE_ID']aLCiOtyt8lyDebzuqil29QAHCAI
$_ENV['FCGI_ROLE']RESPONDER
$_ENV['PHP_SELF']/info-md.php
$_ENV['REQUEST_TIME_FLOAT']1756406330.99
$_ENV['REQUEST_TIME']1756406330
$_ENV['argv']Array
(
)

$_ENV['argc']0


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


Debian Packaging
DEB.SURY.ORG, an Ondřej Surý project

PHP License



This program is free software; you can redistribute it and/or modify it under the terms of the PHP License as published by the PHP Group and included in the distribution in the file:  LICENSE

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

If you did not receive a copy of the PHP license, or have any questions about PHP licensing, please contact license@php.net.




```