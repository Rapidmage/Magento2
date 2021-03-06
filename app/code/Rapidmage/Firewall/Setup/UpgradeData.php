<?php
 
namespace Rapidmage\Firewall\Setup;
 
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
class UpgradeData implements UpgradeDataInterface
{
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
 
        if (version_compare($context->getVersion(), '1.0.1') < 0) {
          
            $tableName = $setup->getTable('rapidmage_rules');
           
            if ($setup->getConnection()->isTableExists($tableName) == true) {
                // Declare data
                $data = [
                    [
                        //    'id''1', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT', 
			            'what' => '(?:\.{2}[\\/]{1,4}){2}\b', 
			            'why' => 'Directory traversal', 
			            'level' => '3', 
			            'enabled' => '1'
                    ],
                    [
                        //    'id''2', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT|REQUEST_URI|PHP_SELF|PATH_INFO', 
			            'what' => '%00|\x00', 
			            'why' => 'NULL byte character', 
			            'level' => '3', 
			            'enabled' => '1'
                    ],
			        [
			            //    'id''3', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT', 
			            'what' => '[.\\/]/(?:proc/self/|etc/passwd)\b', 
			            'why' => 'Local file inclusion', 
			            'level' => '2', 
			            'enabled' => '1'
			         ],
			        [ 				    
			            //    'id''50', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT', 
			            'what' => '^(?i:https?|ftp)://.+/[^&/]+\?$', 
			            'why' => 'Remote file inclusion', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [  
			        	//    'id''51', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT', 
			            'what' => '^(?i:https?)://\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}', 
			            'why' => 'Remote file inclusion (URL IP)', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''52', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT', 
			            'what' => '\b(?i:include|require)(?i:_once)?\s*\([^)]*(?i:https?|ftp)://', 
			            'why' => 'Remote file inclusion (via require/include)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [ 
						//    'id''53', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT', 
			            'what' => '^(?i:ftp)://(?:.+?:.+?\@)?[^/]+/.', 
			            'why' => 'Remote file inclusion (FTP)', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [ 						    
			            //    'id''100', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|REQUEST_URI|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '<\s*/?(?i:applet|div|embed|i?frame(?:set)?|img|meta|marquee|object|script|textarea)\b.*?>', 
			            'why' => 'XSS (HTML tag)', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''101', 
			            'who' => 'generic', 
			            'request' => 'GET|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '\W(?:background(-image)?|-moz-binding)\s*:[^}]*?\burl\s*\([^)]+?://', 
			            'why' => 'XSS (remote background URI)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''102', 
			            'who' => 'generic', 
			            'request' => 'GET|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '(?i:<[^>]+?(?:data|href|src)\s*=\s*[\'\"]?(?:https?|data|php|(?:java|vb)script):)', 
			            'why' => 'XSS (remote URI)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''103', 
			            'who' => 'generic', 
			            'request' => 'GET|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '\b(?i:on(?i:abort|blur|(?:dbl)?click|dragdrop|error|focus|key(?:up|down|press)|(?:un)?load|mouse(?:down|out|over|up)|move|res(?:et|ize)|select|submit))\b\s*=', 
			            'why' => 'XSS (HTML event)', 
			            'level' => '2', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''104', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '[:=\]]\s*[\'\"]?(?:alert|confirm|eval|expression|prompt|String\.fromCharCode|url)\s*\(',
			            'why' => 'XSS (JS function)', 
			            'level' => '3', 
			            'enabled' => '1'
			       ],
			        [ 
			            //    'id''105', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '\bdocument\.(?:body|cookie|location|open|write(?:ln)?)\b', 
			            'why' => 'XSS (document object)', 
			            'level' => '2', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''106', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '\blocation\.(?:href|replace)\b', 
			            'why' => 'XSS (location object)', 
			            'level' => '2', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''107', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '\bwindow\.(?:open|location)\b', 
			            'why' => 'XSS (window object)', 
			            'level' => '2', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''108', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '(?i:style)\s*=\s*[\'"]?[^/\'"]+/\*', 
			            'why' => 'XSS (obfuscated style)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''109', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '^/?>', 
			            'why' => 'XSS (leading greater-than sign)', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''110', 
			            'who' => 'generic', 
			            'request' => 'QUERY_STRING', 
			            'what' => '(?:%%\d\d%\d\d){5}', 
			            'why' => 'XSS (double nibble)', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''111', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|REQUEST_URI|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '(\+|\%2B)A(Dw|ACIAPgA8)-.+?(\+|\%2B)AD4(APAAi)?-', 
			            'why' => 'XSS (UTF-7)', 
			            'level' => '2', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''150', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '[\n\r]\s*\b(?:(?:reply-)?to|b?cc|content-[td]\w)\b\s*:.*?\@', 
			            'why' => 'Mail header injection', 
			            'level' => '2', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''151', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '^[\x0d\x0a]{1,2}[-a-zA-Z0-9]+:\s*\w+', 
			            'why' => 'HTTP header injection', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''152', 
			            'who' => 'generic', 
			            'request' => 'HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '[\x0d\x0a]', 
			            'why' => 'HTTP header injection (CR/LF)', 
			            'level' => '2', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''153', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '<!--#(?:config|echo|exec|flastmod|fsize|include)\b.+?-->', 
			            'why' => 'SSI command injection', 
			            'level' => '2', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''154', 
			            'who' => 'generic', 
			            'request' => 'HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '(?s:<\?.+)|#!/(?:usr|bin)/.+?\s', 
			            'why' => 'Code Injection', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''155', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '(?s:<\?(?![Xx][Mm][Ll]).*?(?:\$_?(?:COOKIE|ENV|FILES|GLOBALS|(?:GE|POS|REQUES)T|SE(RVER|SSION))\s*[=\[)]|\b(?i:array_map|assert|base64_(?:de|en)code|curl_exec|eval|file(?:_get_contents)?|fsockopen|gzinflate|move_uploaded_file|passthru|preg_replace|phpinfo|stripslashes|strrev|system|(?:shell_)?exec)\s*\()|\x60.+?\x60)|#!/(?:usr|bin)/.+?\s|\W\$\{\s*[\'"]\w+[\'"]', 
			            'why' => 'Code Injection', 
			            'level' => '3', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''156', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '\b(?i:eval)\s*\(\s*(?i:base64_decode|exec|file_get_contents|gzinflate|passthru|shell_exec|stripslashes|system)\s*\(', 
			            'why' => 'Code Injection #2', 
			            'level' => '2', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''157', 
			            'who' => 'generic', 
			            'request' => 'GET:fltr', 
			            'what' => ';', 
			            'why' => 'Code injection (phpThumb)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''158', 
			            'who' => 'generic', 
			            'request' => 'GET:file_to_serve', 
			            'what' => 'flowplayer/3\.1\.1/flowplayer-3\.1\.1\.min.js', 
			            'why' => 'Code injection (OpenX backdoor)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''159', 
			            'who' => 'generic', 
			            'request' => 'GET:phpThumbDebug', 
			            'what' => '.', 
			            'why' => 'phpThumb debug mode (potential SSRF)', 
			            'level' => '1', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''200', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE', 
			            'what' => '^(?i:admin(?:istrator)?)[\'"].*?(?:--|#|/\*)', 
			            'why' => 'SQL injection (admin login attempt)', 
			            'level' => '3', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''201', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '\b(?i:[-\w]+@(?:[-a-z0-9]+\.)+[a-z]{2,8}\'.{0,20}\band\b.{0,20}=[\s/*]*\')', 
			            'why' => 'SQL injection (user login attempt)', 
			            'level' => '3', 
			            'enabled' => '1'
			       ],
			        [ 
			            //    'id''202', 
			            'who' => 'generic', 
			            'request' => 'GET:username|POST:username', 
			            'what' => '[#\'"=(),<>/\\*\x60]', 
			            'why' => 'SQL injection (username)', 
			            'level' => '3', 
			            'enabled' => '1'
			       ],
			        [ 
			            //    'id''204', 
			            'who' => 'generic', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '\b(?i:and|or|having)\b.+?[\'"]?(\w+)[\'"]?\s*=\s*[\'"]?\1', 
			            'why' => 'SQL injection (equal operator)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''205', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '(?i:(?:\b(?:and|or|union)\b|;|\').*?\bfrom\b.+?information_schema\b)', 
			            'why' => 'SQL injection (information_schema)', 
			            'level' => '3', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''206', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '/\*\*/(?i:and|from|limit|or|select|union|request)/\*\*/', 
			            'why' => 'SQL injection (comment obfuscation)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''207', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '^[-\d\';].+\w.+(?:--|#|/\*)\s*$', 
			            'why' => 'SQL injection (trailing comment)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''208', 
			            'who' => 'generic', 
			            'request' => 'HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '(?i:(?:\b(?:and|or|union)\b|;|\').*?\b(?:alter|create|delete|drop|grant|information_schema|insert|load|rename|select|truncate|update)[^-\w])', 
			            'why' => 'SQL injection', 
			            'level' => '1', 
			            'enabled' => '1'
			        ],
			        [ 
			            //    'id''209', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '(?i:(?:\b(?:and|or|union)\b|;|\').*?(?:\ball\b.+?)?\bselect\b.+?\b(?:and\b|from\b|limit\b|request\b|\@?\@?version\b|(?:user|benchmark|char|count|database|(?:group_)?concat(?:_ws)?|floor|md5|rand|substring|version)\s*\(|--|/\*|#$))', 
			            'why' => 'SQL injection (select)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [ 
			            //    'id''210', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '(?i:(?:\b(?:and|or|union)\b|;|\').*?(?:\ball\b.+?)?\binsert\b.+?\binto\b.*?\([^)]+\).+?values.*?\()', 
			            'why' => 'SQL injection (insert)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''211', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '(?i:(?:\b(?:and|or|union)\b|;|\').*?\bupdate\b.+?\bset\b.+?=)', 
			            'why' => 'SQL injection (update)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [ 
			            //    'id''212', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '(?i:(?:\b(?:and|or|union)\b|;|\').*?\bgrant\b.+?\bon\b.+?to\s+)', 
			            'why' => 'SQL injection (grant)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''213', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '(?i:(?:\b(?:and|or|union)\b|;|\').*?\bdelete\b.+?\bfrom\b.+)', 
			            'why' => 'SQL injection (delete)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''214', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '(?i:(?:\b(?:and|or|union)\b|;|\').*?\b(alter|create|drop)\b.+?(?:DATABASE|FUNCTION|INDEX|PROCEDURE|SCHEMA|TABLE|TRIGGER|VIEW)\b.+?)', 
			            'why' => 'SQL injection (alter/create/drop)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''215', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '(?i:(?:\b(?:and|or|union)\b|;|\').*?\b(?:rename|truncate)\b.+?table)', 
			            'why' => 'SQL injection (rename/truncate)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''216', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '(?i:(?:\b(?:and|or|union)\b|;|\').*?\bselect\b.+?\b(?:into\b.+?(?:(?:dump|out)file|\@[\'"\x60]?\w+)|load_file))\b', 
			            'why' => 'SQL injection (select into/load_file)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''217', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '(?i:(?:\b(?:and|or|union)\b|;|\').*?load\b.+?\bdata\b.+?\binfile\b.+?\binto)\b', 
			            'why' => 'SQL injection (load)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''250', 
			            'who' => 'generic', 
			            'request' => 'HTTP_HOST', 
			            'what' => '[^-a-zA-Z0-9._:\[\]]', 
			            'why' => 'Malformed Host header', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''300', 
			            'who' => 'generic', 
			            'request' => 'GET|POST', 
			            'what' => '^[\'"]', 
			            'why' => 'Leading quote', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''301', 
			            'who' => 'generic', 
			            'request' => 'GET', 
			            'what' => '^[\x09\x20]', 
			            'why' => 'Leading space', 
			            'level' => '1', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''302', 
			            'who' => 'generic', 
			            'request' => 'QUERY_STRING|PATH_INFO', 
			            'what' => '\bHTTP_RAW_POST_DATA|HTTP_(?:POS|GE)T_VARS\b', 
			            'why' => 'PHP variable', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [ 
			            //    'id''303', 
			            'who' => 'generic', 
			            'request' => 'SCRIPT_NAME', 
			            'what' => 'phpinfo\.php', 
			            'why' => 'Attempt to access phpinfo.php', 
			            'level' => '1', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''304', 
			            'who' => 'generic', 
			            'request' => 'SCRIPT_NAME', 
			            'what' => '/scripts/(?:setup|signon)\.php', 
			            'why' => 'phpMyAdmin hacking attempt', 
			            'level' => '2', 
			            'enabled' => '1'
			       ],
			        [ 
			            //    'id''305', 
			            'who' => 'generic', 
			            'request' => 'SCRIPT_NAME', 
			            'what' => '\.ph(?:p[2-6]?|tml)\..+?', 
			            'why' => 'PHP handler obfuscation', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [ 
			            //    'id''306', 
			            'who' => 'generic', 
			            'request' => 'GET:mosConfig_absolute_path|POST:mosConfig_absolute_path', 
			            'what' => '.', 
			            'why' => 'mosConfig_absolute_path override attempt', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''307', 
			            'who' => 'generic', 
			            'request' => 'GET:mosConfig_live_site|POST:mosConfig_live_site', 
			            'what' => '.', 
			            'why' => 'mosConfig_live_site override attempt', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''308', 
			            'who' => 'generic', 
			            'request' => 'GET:mosConfig_cachepath|POST:mosConfig_cachepath', 
			            'what' => '.', 
			            'why' => 'mosConfig_cachepath override attempt', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [ 
			            //    'id''309', 
			            'who' => 'generic', 
			            'request' => 'QUERY_STRING|PATH_INFO|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '\b(?:\$?_(COOKIE|ENV|FILES|(?:GE|POS|REQUES)T|SE(RVER|SSION))|HTTP_(?:(?:POST|GET)_VARS|RAW_POST_DATA)|GLOBALS)\s*[=\[]|\W\$\{\s*[\'"]\w+[\'"]', 
			            'why' => 'PHP predefined variables', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''310', 
			            'who' => 'generic', 
			            'request' => 'HTTP_USER_AGENT', 
			            'what' => '(?i:acunetix|analyzer|AhrefsBot|backdoor|bandit|blackwidow|BOT for JCE|collect|core-project|dts agent|emailmagnet|ex(ploit|tract)|flood|grabber|harvest|httrack|havij|hunter|indy library|inspect|LoadTimeBot|Microsoft URL Control|mj12bot|morfeus|nessus|pmafind|scanner|siphon|sqlmap|survey|teleport)', 
			            'why' => 'Bad User-agent', 
			            'level' => '1', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''311', 
			            'who' => 'generic', 
			            'request' => 'SCRIPT_NAME', 
			            'what' => '/tiny_?mce/plugins/spellchecker/classes/', 
			            'why' => 'TinyMCE path disclosure', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''312', 
			            'who' => 'generic', 
			            'request' => 'HTTP_X_FORWARDED_FOR', 
			            'what' => '[^.0-9a-f:\x20,unkow]', 
			            'why' => 'Non-compliant X_FORWARDED_FOR', 
			            'level' => '1', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''313', 
			            'who' => 'generic', 
			            'request' => 'QUERY_STRING', 
			            'what' => '^-[bcndfiswzT]', 
			            'why' => 'PHP-CGI exploit (CVE-2012-1823)', 
			            'level' => '2', 
			            'enabled' => '1'
			       ],
			        [ 
			            //    'id''350', 
			            'who' => 'generic', 
			            'request' => 'SCRIPT_NAME', 
			            'what' => '(?i:bypass|c99(?:madShell|ud)?|c100|cookie_(?:usage|setup)|diagnostics|dump|endix|gifimg|goog[l1]e.+[\da-f]{10}|imageth|imlog|r5[47]|safe0ver|sniper|(?:jpe?g|gif|png))\.ph(?:p[2-6]?|tml)', 
			            'why' => 'Shell/backdoor', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''351', 
			            'who' => 'generic', 
			            'request' => 'GET:nixpasswd|POST:nixpasswd', 
			            'what' => '^.?', 
			            'why' => 'Shell/backdoor (nixpasswd)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''352', 
			            'who' => 'generic', 
			            'request' => 'QUERY_STRING', 
			            'what' => '\bact=img&img=\w', 
			            'why' => 'Shell/backdoor (img)', 
			            'level' => '3', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''353', 
			            'who' => 'generic', 
			            'request' => 'QUERY_STRING', 
			            'what' => '\bc=img&name=\w', 
			            'why' => 'Shell/backdoor (name)', 
			            'level' => '3', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''354', 
			            'who' => 'generic', 
			            'request' => 'QUERY_STRING', 
			            'what' => '^image=(?:arrow|file|folder|smiley)$', 
			            'why' => 'Shell/backdoor (image)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''355', 
			            'who' => 'generic', 
			            'request' => 'HTTP_COOKIE', 
			            'what' => '\buname=.+?;\ssysctl=', 
			            'why' => 'Shell/backdoor (cookie)', 
			            'level' => '3', 
			            'enabled' => '1'
			       ],
			        [ 
			            //    'id''356', 
			            'who' => 'generic', 
			            'request' => 'POST:sql_passwd|GET:sql_passwd', 
			            'what' => '.', 
			            'why' => 'Shell/backdoor (sql_passwd)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''357', 
			            'who' => 'generic', 
			            'request' => 'POST:nowpath', 
			            'what' => '^.?', 
			            'why' => 'Shell/backdoor (nowpath)', 
			            'level' => '3', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''358', 
			            'who' => 'generic', 
			            'request' => 'POST:view_writable', 
			            'what' => '^.?', 
			            'why' => 'Shell/backdoor (view_writable)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''359', 
			            'who' => 'generic', 
			            'request' => 'HTTP_COOKIE', 
			            'what' => '\bphpspypass=', 
			            'why' => 'Shell/backdoor (phpspy)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''360', 
			            'who' => 'generic', 
			            'request' => 'POST:a', 
			            'what' => '^(?:Bruteforce|Console|Files(?:Man|Tools)|Network|Php|SecInfo|SelfRemove|Sql|StringTools)$', 
			            'why' => 'Shell/backdoor (a)', 
			            'level' => '3', 
			            'enabled' => '1'
			       ],
			        [
			            //    'id''361', 
			            'who' => 'generic', 
			            'request' => 'POST:nst_cmd', 
			            'what' => '^.', 
			            'why' => 'Shell/backdoor (nstview)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''362', 
			            'who' => 'generic', 
			            'request' => 'POST:cmd', 
			            'what' => '^(?:c(?:h_|URL)|db_query|echo\s\\.*|(?:edit|download|save)_file|find(?:_text|\s.+)|ftp_(?:brute|file_(?:down|up))|mail_file|mk|mysql(?:b|_dump)|php_eval|ps\s.*|search_text|safe_dir|sym[1-2]|test[1-8]|zend)$', 
			            'why' => 'Shell/backdoor (cmd)', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''363', 
			            'who' => 'generic', 
			            'request' => 'GET:p', 
			            'what' => '^(?:chmod|cmd|edit|eval|delete|headers|md5|mysql|phpinfo|rename)$', 
			            'why' => 'Shell/backdoor (p)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''364', 
			            'who' => 'generic', 
			            'request' => 'QUERY_STRING', 
			            'what' => '^act=(?:bind|cmd|encoder|eval|feedback|ftpquickbrute|gofile|ls|mkdir|mkfile|processes|ps_aux|search|security|sql|tools|update|upload)&d=%2F', 
			            'why' => 'Shell/backdoor (act)', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''500', 
			            'who' => 'option', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '[\x01-\x08\x0e-\x1f]', 
			            'why' => 'Disallowed ASCII characters', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''520', 
			            'who' => 'option', 
			            'request' => 'GET|POST|HTTP_COOKIE|HTTP_USER_AGENT|HTTP_REFERER', 
			            'what' => '\b(?i:php://[a-z].+?|\bdata:.*?;base64,)', 
			            'why' => 'PHP wrappers', 
			            'level' => '3', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''1200', 
			            'who' => 'magento', 
			            'request' => 'SCRIPT_NAME', 
			            'what' => '/(?:[Cc]onfig|install)\.php', 
			            'why' => 'Magento: unauthorised access to a PHP script', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''1201', 
			            'who' => 'magento', 
			            'request' => 'SCRIPT_NAME', 
			            'what' => '/(?:app|cache|includes|js(?!/index\.php)|lib|media|pkginfo|var)/', 
			            'why' => 'Magento: unauthorised access to a PHP script', 
			            'level' => '2', 
			            'enabled' => '1'
			        ],
			        [
			            //    'id''1202', 
			            'who' => 'magento', 
			            'request' => 'GET|POST', 
			            'what' => '\badmin_user\b', 
			            'why' => 'Magento: SQL injection (admin_user)', 
			            'level' => '2', 
			            'enabled' => '1'
			        ]
			];
			

 
                // Insert data to table
                foreach ($data as $item) {
                    $setup->getConnection()->insert($tableName, $item);
                }
            }
        }
 
        $setup->endSetup();
    }
}
