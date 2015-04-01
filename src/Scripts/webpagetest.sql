-- Drop the existing database
DROP DATABASE IF EXISTS `webpagetest`;

-- Create a new database
CREATE DATABASE IF NOT EXISTS `webpagetest`
	DEFAULT CHARACTER SET = 'utf8';

-- Create a new table webpagetest.tests
CREATE TABLE `webpagetest`.`tests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` varchar(100) NOT NULL,
  `status_code` int(5) unsigned NOT NULL,
  `status_text` varchar(45) NOT NULL,
  `request_time` datetime NOT NULL,
  `processed` tinyint(1) unsigned DEFAULT '0',
  `spec_filepath` varchar(200) DEFAULT NULL,
  `owner_key` varchar(100) DEFAULT NULL,
  `json_url` varchar(100) NOT NULL,
  `xml_url` varchar(100) NOT NULL,
  `user_url` varchar(200) NOT NULL,
  `summary_csv_url` varchar(200) NOT NULL,
  `detail_csv_url` varchar(100) NOT NULL,
  `url` varchar(200) NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `runs` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `fvonly` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `domelement` int(5) DEFAULT '0',
  `private` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `connections` int(4) unsigned NOT NULL DEFAULT '0',
  `web10` int(6) unsigned NOT NULL DEFAULT '0',
  `script` varchar(300) DEFAULT NULL,
  `block` varchar(300) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `auth_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `video` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `f` varchar(20) NOT NULL DEFAULT 'json',
  `r` varchar(45) DEFAULT NULL,
  `notify` varchar(100) DEFAULT NULL,
  `pingback` varchar(200) DEFAULT NULL,
  `bw_down` int(6) unsigned DEFAULT NULL,
  `bw_up` int(6) unsigned DEFAULT NULL,
  `latency` int(11) unsigned DEFAULT '0',
  `plr` tinyint(3) DEFAULT '0',
  `k` varchar(100) DEFAULT NULL,
  `tcpdump` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `noopt` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `noimages` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `noheaders` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `pngss` tinyint(1) unsigned DEFAULT NULL,
  `iq` tinyint(3) DEFAULT '0',
  `noscript` tinyint(1) unsigned DEFAULT '0',
  `clearcerts` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mobile` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `mv` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cmdline` varchar(200) DEFAULT NULL,
  `htmlbody` tinyint(1) unsigned DEFAULT '0',
  `tsview_id` varchar(100) DEFAULT NULL,
  `custom` varchar(300) DEFAULT NULL,
  `tester` varchar(100) DEFAULT NULL,
  `affinity` varchar(100) DEFAULT NULL,
  `timeline` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `timeline_stack` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `test_id_UNIQUE` (`test_id`),
  UNIQUE KEY `json_url_UNIQUE` (`json_url`),
  UNIQUE KEY `xml_url_UNIQUE` (`xml_url`),
  UNIQUE KEY `user_url_UNIQUE` (`user_url`),
  UNIQUE KEY `summary_csv_url_UNIQUE` (`summary_csv_url`),
  UNIQUE KEY `detail_csv_url_UNIQUE` (`detail_csv_url`),
  KEY `idx_test_id` (`test_id`),
  KEY `idx_status_code` (`status_code`),
  KEY `idx_request_time` (`request_time`),
  KEY `idx_processed` (`processed`),
  KEY `idx_owner_key` (`owner_key`),
  KEY `idx_url` (`url`),
  KEY `idx_label` (`label`),
  KEY `idx_location` (`location`),
  KEY `idx_runs` (`runs`),
  KEY `idx_fvonly` (`fvonly`),
  KEY `idx_domelement` (`domelement`),
  KEY `idx_private` (`private`),
  KEY `idx_connections` (`connections`),
  KEY `idx_script` (`script`(255)),
  KEY `idx_block` (`block`(255)),
  KEY `idx_login` (`login`),
  KEY `idx_password` (`password`),
  KEY `idx_auth_type` (`auth_type`),
  KEY `idx_video` (`video`),
  KEY `idx_f` (`f`),
  KEY `idx_r` (`r`),
  KEY `idx_notify` (`notify`),
  KEY `idx_pingback` (`pingback`),
  KEY `idx_bw_down` (`bw_down`),
  KEY `idx_bw_up` (`bw_up`),
  KEY `idx_latency` (`latency`),
  KEY `idx_plr` (`plr`),
  KEY `idx_k` (`k`),
  KEY `idx_tcpdump` (`tcpdump`),
  KEY `idx_noopt` (`noopt`),
  KEY `idx_noimages` (`noimages`),
  KEY `idx_noheaders` (`noheaders`),
  KEY `idx_pngss` (`pngss`),
  KEY `idx_iq` (`iq`),
  KEY `idx_noscript` (`noscript`),
  KEY `idx_clearcerts` (`clearcerts`),
  KEY `idx_mobile` (`mobile`),
  KEY `idx_mv` (`mv`),
  KEY `idx_cmdline` (`cmdline`),
  KEY `idx_htmlbody` (`htmlbody`),
  KEY `idx_tsview_id` (`tsview_id`),
  KEY `idx_custom` (`custom`(255)),
  KEY `idx_tester` (`tester`),
  KEY `idx_affinity` (`affinity`),
  KEY `idx_timeline` (`timeline`),
  KEY `idx_timeline_stack` (`timeline_stack`),
  KEY `idx_created_date` (`created_date`),
  KEY `idx_update_date` (`update_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create a new table webpagetest.summary
CREATE TABLE `webpagetest`.`summary` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `testid` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `eventname` varchar(200) DEFAULT NULL,
  `url` varchar(200) NOT NULL,
  `loadtimems` varchar(10) DEFAULT NULL,
  `timetofirstbytems` varchar(10) DEFAULT NULL,
  `unused` varchar(45) DEFAULT NULL,
  `bytesout` varchar(10) DEFAULT NULL,
  `bytesin` varchar(10) DEFAULT NULL,
  `dnslookups` varchar(10) DEFAULT NULL,
  `connections` varchar(10) DEFAULT NULL,
  `requests` varchar(10) DEFAULT NULL,
  `okresponses` varchar(10) DEFAULT NULL,
  `redirects` varchar(10) DEFAULT NULL,
  `notmodified` varchar(10) DEFAULT NULL,
  `notfound` varchar(10) DEFAULT NULL,
  `otherresponses` varchar(10) DEFAULT NULL,
  `errorcode` varchar(10) NOT NULL DEFAULT '99999',
  `timetostartrenderms` varchar(10) DEFAULT NULL,
  `segmentstransmitted` varchar(10) DEFAULT NULL,
  `segmentsretransmitted` varchar(10) DEFAULT NULL,
  `packetlossout` varchar(10) DEFAULT NULL,
  `activitytimems` varchar(10) DEFAULT NULL,
  `descriptor` varchar(45) DEFAULT NULL,
  `labid` varchar(10) DEFAULT NULL,
  `dialerid` varchar(10) DEFAULT NULL,
  `connectiontype` varchar(45) DEFAULT NULL,
  `cached` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `eventurl` varchar(200) DEFAULT NULL,
  `pagetestbuild` varchar(10) DEFAULT NULL,
  `measurementtype` varchar(10) DEFAULT NULL,
  `experimental` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `doccompletetimems` varchar(10) DEFAULT NULL,
  `eventguid` varchar(45) DEFAULT NULL,
  `timetodomelementms` varchar(10) DEFAULT NULL,
  `includesobjectdata` tinyint(1) unsigned DEFAULT '0',
  `cachescore` varchar(10) DEFAULT NULL,
  `staticcdnscore` varchar(10) DEFAULT NULL,
  `onecdnscore` varchar(10) DEFAULT '-1',
  `gzipscore` varchar(10) DEFAULT NULL,
  `cookiescore` varchar(10) DEFAULT '-1',
  `keepalivescore` varchar(10) DEFAULT NULL,
  `doctypescore` varchar(10) DEFAULT '-1',
  `minifyscore` varchar(10) DEFAULT '-1',
  `combinescore` varchar(10) DEFAULT NULL,
  `bytesoutdoc` varchar(10) DEFAULT NULL,
  `bytesindoc` varchar(10) DEFAULT NULL,
  `dnslookupsdoc` varchar(10) DEFAULT NULL,
  `connectionsdoc` varchar(10) DEFAULT NULL,
  `requestsdoc` varchar(10) DEFAULT NULL,
  `okresponsesdoc` varchar(10) DEFAULT NULL,
  `redirectsdoc` varchar(10) DEFAULT NULL,
  `notmodifieddoc` varchar(10) DEFAULT NULL,
  `notfounddoc` varchar(10) DEFAULT NULL,
  `otherresponsesdoc` varchar(10) DEFAULT NULL,
  `compressionscore` varchar(10) DEFAULT NULL,
  `host` varchar(100) DEFAULT NULL,
  `ipaddress` varchar(45) DEFAULT NULL,
  `etagscore` varchar(10) DEFAULT NULL,
  `flaggedrequests` varchar(10) DEFAULT NULL,
  `flaggedconnections` varchar(10) DEFAULT NULL,
  `maxsimultaneousflaggedconnection` varchar(10) DEFAULT NULL,
  `timetobasepagecompletems` varchar(10) DEFAULT NULL,
  `basepageresult` varchar(10) DEFAULT NULL,
  `gziptotalbytes` varchar(10) DEFAULT NULL,
  `gzipsavingsbytes` varchar(10) DEFAULT NULL,
  `minifytotalbytes` varchar(10) DEFAULT NULL,
  `minifysavingsbytes` varchar(10) DEFAULT NULL,
  `imagetotalbytes` varchar(10) DEFAULT NULL,
  `imagesavingsbytes` varchar(10) DEFAULT NULL,
  `basepageredirects` varchar(10) DEFAULT NULL,
  `optimizationchecked` tinyint(1) unsigned DEFAULT '1',
  `aftms` varchar(10) DEFAULT NULL,
  `domelements` varchar(10) DEFAULT NULL,
  `pagespeedversion` varchar(20) DEFAULT NULL,
  `pagetitle` varchar(200) DEFAULT NULL,
  `timetotitlems` varchar(10) DEFAULT NULL,
  `loadeventstartms` varchar(10) DEFAULT NULL,
  `loadeventendms` varchar(10) DEFAULT NULL,
  `domcontentreadystartms` varchar(10) DEFAULT NULL,
  `domcontentreadyendms` varchar(10) DEFAULT NULL,
  `visuallycompletems` varchar(10) DEFAULT NULL,
  `browsername` varchar(100) NOT NULL,
  `browserversion` varchar(100) NOT NULL,
  `basepageserver` varchar(10) DEFAULT NULL,
  `basepageserverrit` varchar(10) DEFAULT NULL,
  `basepagecdn` varchar(10) DEFAULT NULL,
  `adultsite` tinyint(1) unsigned DEFAULT '0',
  `run` int(3) unsigned NOT NULL DEFAULT '1',
  `speedindex` varchar(10) DEFAULT NULL,
  `createddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifieddate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `test_id_UNIQUE` (`testid`),
  KEY `ix_date` (`date`),
  KEY `ix_time` (`time`),
  KEY `ix_url` (`url`),
  KEY `ix_load_time_ms` (`loadtimems`),
  KEY `ix_bytes_out` (`bytesout`),
  KEY `ix_bytes_in` (`bytesin`),
  KEY `ix_time_to_start_render_ms` (`timetostartrenderms`),
  KEY `ix_activity_time_ms` (`activitytimems`),
  KEY `ix_connection_type` (`connectiontype`),
  KEY `ix_cached` (`cached`),
  KEY `ix_event_url` (`eventurl`),
  KEY `ix_document_complete_time_ms` (`doccompletetimems`),
  KEY `ix_time_to_dom_element_ms` (`timetodomelementms`),
  KEY `ix_includes_object_data` (`includesobjectdata`),
  KEY `ix_cache_score` (`cachescore`),
  KEY `ix_static_cdn_score` (`staticcdnscore`),
  KEY `ix_gzip_score` (`gzipscore`),
  KEY `ix_cookie_score` (`cookiescore`),
  KEY `ix_keep_alive_score` (`keepalivescore`),
  KEY `ix_minify_score` (`minifyscore`),
  KEY `ix_combine_score` (`combinescore`),
  KEY `ix_compression_score` (`compressionscore`),
  KEY `ix_host` (`host`),
  KEY `ix_ip_address` (`ipaddress`),
  KEY `ix_etag_score` (`etagscore`),
  KEY `ix_time_to_base_page_complete_ms` (`timetobasepagecompletems`),
  KEY `ix_gzip_total_bytes` (`gziptotalbytes`),
  KEY `ix_gzip_savings_bytes` (`gzipsavingsbytes`),
  KEY `ix_minify_total_bytes` (`minifytotalbytes`),
  KEY `ix_minify_savings_bytes` (`minifysavingsbytes`),
  KEY `ix_image_total_byets` (`imagetotalbytes`),
  KEY `ix_image_savings_byets` (`imagesavingsbytes`),
  KEY `ix_base_page_redirects` (`basepageredirects`),
  KEY `ix_aft_ms` (`aftms`),
  KEY `ix_time_to_title_ms` (`timetotitlems`),
  KEY `ix_load_event_start_ms` (`loadeventstartms`),
  KEY `ix_load_event_end_ms` (`loadeventendms`),
  KEY `ix_dom_content_ready_start_ms` (`domcontentreadystartms`),
  KEY `ix_dom_content_ready_end_ms` (`domcontentreadyendms`),
  KEY `ix_visually_complete_ms` (`visuallycompletems`),
  KEY `ix_browser_name` (`browsername`),
  KEY `ix_browser_version` (`browserversion`),
  KEY `ix_base_page_cdn` (`basepagecdn`),
  KEY `ix_run` (`run`),
  KEY `ix_speed_index` (`speedindex`),
  KEY `ix_event_name` (`eventname`),
  KEY `ix_time_to_first_byte_ms` (`timetofirstbytems`),
  KEY `ix_dns_lookups` (`dnslookups`),
  KEY `ix_connections` (`connections`),
  KEY `ix_requests` (`requests`),
  KEY `ix_ok_responses` (`okresponses`),
  KEY `ix_redirects` (`redirects`),
  KEY `ix_not_modified` (`notmodified`),
  KEY `ix_not_found` (`notfound`),
  KEY `ix_other_responses` (`otherresponses`),
  KEY `ix_flagged_requests` (`flaggedrequests`),
  KEY `ix_flagged_connections` (`flaggedconnections`),
  KEY `ix_dom_elements` (`domelements`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Create a new table webpagetest.requests
CREATE TABLE `webpagetest`.`requests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `testid` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `eventname` varchar(100) DEFAULT NULL,
  `ipaddress` varchar(20) DEFAULT NULL,
  `action` varchar(20) DEFAULT 'GET',
  `host` varchar(100) DEFAULT NULL,
  `url` varchar(500) DEFAULT NULL,
  `responsecode` varchar(10) DEFAULT NULL,
  `timetoloadms` varchar(10) DEFAULT '0',
  `timetofirstbytems` varchar(10) DEFAULT NULL,
  `starttimems` varchar(10) DEFAULT NULL,
  `bytesout` varchar(10) DEFAULT NULL,
  `bytesin` varchar(10) DEFAULT NULL,
  `objectsize` varchar(10) DEFAULT NULL,
  `cookiesizeout` varchar(10) DEFAULT NULL,
  `cookiecountout` varchar(10) DEFAULT NULL,
  `expires` varchar(200) DEFAULT NULL,
  `cachecontrol` varchar(200) DEFAULT NULL,
  `contenttype` varchar(45) DEFAULT NULL,
  `contentencoding` varchar(45) DEFAULT NULL,
  `transactiontype` varchar(5) DEFAULT NULL,
  `socketid` varchar(10) DEFAULT NULL,
  `documentid` varchar(10) DEFAULT NULL,
  `endtimems` varchar(10) DEFAULT NULL,
  `descriptor` varchar(45) DEFAULT NULL,
  `labid` varchar(10) DEFAULT NULL,
  `dialerid` varchar(10) DEFAULT NULL,
  `connectiontype` varchar(10) DEFAULT NULL,
  `cached` varchar(5) DEFAULT '0',
  `eventurl` varchar(200) DEFAULT NULL,
  `pagetestbuild` varchar(10) DEFAULT NULL,
  `measurementtype` varchar(10) DEFAULT NULL,
  `experimental` varchar(5) DEFAULT NULL,
  `eventguid` varchar(45) DEFAULT NULL,
  `sequencenumber` varchar(5) DEFAULT NULL,
  `cachescore` varchar(5) DEFAULT '0',
  `staticcdnscore` varchar(5) DEFAULT '0',
  `gzipscore` varchar(5) DEFAULT '0',
  `cookiescore` varchar(5) DEFAULT '0',
  `keepalivescore` varchar(5) DEFAULT '0',
  `doctypescore` varchar(5) DEFAULT '0',
  `minifyscore` varchar(5) DEFAULT '0',
  `combinescore` varchar(5) DEFAULT '0',
  `compressionscore` varchar(5) DEFAULT '0',
  `etagscore` varchar(5) DEFAULT '0',
  `flagged` varchar(5) DEFAULT '0',
  `secure` varchar(5) DEFAULT '0',
  `dnstime` varchar(5) DEFAULT '-1',
  `connecttime` varchar(10) DEFAULT '-1',
  `ssltime` varchar(10) DEFAULT '-1',
  `gziptotalbytes` varchar(10) DEFAULT '0',
  `gzipsavings` varchar(10) DEFAULT '0',
  `minifytotalbytes` varchar(10) DEFAULT '0',
  `minifysavings` varchar(10) DEFAULT '0',
  `imagetotalbytes` varchar(10) DEFAULT '0',
  `imagesavings` varchar(10) DEFAULT '0',
  `cachetimesec` varchar(10) DEFAULT NULL,
  `realstarttimems` varchar(10) DEFAULT NULL,
  `fulltimetoloadms` varchar(10) DEFAULT NULL,
  `optimizationchecked` varchar(5) DEFAULT '0',
  `cdnprovider` varchar(20) DEFAULT NULL,
  `dnsstart` varchar(10) DEFAULT '0',
  `dnsend` varchar(10) DEFAULT '0',
  `connectstart` varchar(10) DEFAULT '0',
  `connectend` varchar(10) DEFAULT '0',
  `sslnegotiationstart` varchar(10) DEFAULT '0',
  `sslnegotiationend` varchar(10) DEFAULT '0',
  `initiator` varchar(500) DEFAULT NULL,
  `initiatorline` varchar(5) DEFAULT NULL,
  `initiatorcolumn` varchar(5) DEFAULT NULL,
  `servercount` varchar(5) DEFAULT NULL,
  `serverrtt` varchar(10) DEFAULT NULL,
  `run` varchar(5) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ix_date` (`date`),
  KEY `ix_time` (`time`),
  KEY `ix_eventname` (`eventname`),
  KEY `ix_ipaddress` (`ipaddress`),
  KEY `ix_action` (`action`),
  KEY `ix_host` (`host`),
  KEY `ix_url` (`url`(255)),
  KEY `ix_responsecode` (`responsecode`),
  KEY `ix_timetoloadms` (`timetoloadms`),
  KEY `ix_timetofirstbytems` (`timetofirstbytems`),
  KEY `ix_starttimems` (`starttimems`),
  KEY `ix_bytesout` (`bytesout`),
  KEY `ix_bytesin` (`bytesin`),
  KEY `ix_objectsize` (`objectsize`),
  KEY `ix_cookiesizeout` (`cookiesizeout`),
  KEY `ix_cookiecountout` (`cookiecountout`),
  KEY `ix_expires` (`expires`),
  KEY `ix_cachecontrol` (`cachecontrol`),
  KEY `ix_contenttype` (`contenttype`),
  KEY `ix_contentencoding` (`contentencoding`),
  KEY `ix_endtimems` (`endtimems`),
  KEY `ix_connectiontype` (`connectiontype`),
  KEY `ix_cached` (`cached`),
  KEY `ix_eventurl` (`eventurl`),
  KEY `ix_experimental` (`experimental`),
  KEY `ix_cachescore` (`cachescore`),
  KEY `ix_staticcdnscore` (`staticcdnscore`),
  KEY `ix_gzipscore` (`gzipscore`),
  KEY `ix_cookiescore` (`cookiescore`),
  KEY `ix_keepalivescore` (`keepalivescore`),
  KEY `ix_doctypescore` (`doctypescore`),
  KEY `ix_minifyscore` (`minifyscore`),
  KEY `ix_combinescore` (`combinescore`),
  KEY `ix_compressionscore` (`compressionscore`),
  KEY `ix_etagscore` (`etagscore`),
  KEY `ix_flagged` (`flagged`),
  KEY `ix_secure` (`secure`),
  KEY `ix_dnstime` (`dnstime`),
  KEY `ix_connecttime` (`connecttime`),
  KEY `ix_ssltime` (`ssltime`),
  KEY `ix_gziptotalbytes` (`gziptotalbytes`),
  KEY `ix_gzipsavings` (`gzipsavings`),
  KEY `ix_minifytotalbytes` (`minifytotalbytes`),
  KEY `ix_minifysavings` (`minifysavings`),
  KEY `ix_imagetotalbytes` (`imagetotalbytes`),
  KEY `ix_imagesavings` (`imagesavings`),
  KEY `ix_cachetimesec` (`cachetimesec`),
  KEY `ix_realstarttimems` (`realstarttimems`),
  KEY `ix_fulltimetoloadms` (`fulltimetoloadms`),
  KEY `ix_optimizationchecked` (`optimizationchecked`),
  KEY `ix_cdnprovider` (`cdnprovider`),
  KEY `ix_dnsstart` (`dnsstart`),
  KEY `ix_dnsend` (`dnsend`),
  KEY `ix_connectstart` (`connectstart`),
  KEY `ix_connectend` (`connectend`),
  KEY `ix_sslnegotiationstart` (`sslnegotiationstart`),
  KEY `ix_sslnegotiationend` (`sslnegotiationend`),
  KEY `ix_initiator` (`initiator`(255)),
  KEY `ix_servercount` (`servercount`),
  KEY `ix_serverrtt` (`serverrtt`),
  KEY `ix_run` (`run`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;