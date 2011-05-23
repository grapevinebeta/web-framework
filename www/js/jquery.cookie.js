
    

  

<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <script>var NREUMQ=[];NREUMQ.push(["mark","firstbyte",new Date().getTime()]);(function(){var d=document;var e=d.createElement("script");e.type="text/javascript";e.async=true;e.src="https://d1ros97qkrwjf5.cloudfront.net/9/eum/rum.js	";var s=d.getElementsByTagName("script")[0];s.parentNode.insertBefore(e,s);})()</script>
        <title>jquery.cookie.js at master from carhartl/jquery-cookie - GitHub</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub" />
    <link rel="fluid-icon" href="https://github.com/fluidicon.png" title="GitHub" />

    <link href="https://d3nwyuy0nl342s.cloudfront.net/09b99849dd9ea2ca0ba950536f1412f88d87f8c4/stylesheets/bundle_github.css" media="screen" rel="stylesheet" type="text/css" />
    

    <script type="text/javascript">
      if (typeof console == "undefined" || typeof console.log == "undefined")
        console = { log: function() {} }
    </script>
    <script type="text/javascript" charset="utf-8">
      var GitHub = {
        assetHost: 'https://d3nwyuy0nl342s.cloudfront.net'
      }
      var github_user = 'jacekkromskipolcode'
      
    </script>
    <script src="https://d3nwyuy0nl342s.cloudfront.net/09b99849dd9ea2ca0ba950536f1412f88d87f8c4/javascripts/jquery/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script src="https://d3nwyuy0nl342s.cloudfront.net/09b99849dd9ea2ca0ba950536f1412f88d87f8c4/javascripts/bundle_github.js" type="text/javascript"></script>


    
    <script type="text/javascript" charset="utf-8">
      GitHub.spy({
        repo: "carhartl/jquery-cookie"
      })
    </script>

    
  <link rel='canonical' href='/carhartl/jquery-cookie/blob/67fb34f6a866c40d0570265e8fa5911605d92616/jquery.cookie.js'>

  <link href="https://github.com/carhartl/jquery-cookie/commits/master.atom" rel="alternate" title="Recent Commits to jquery-cookie:master" type="application/atom+xml" />

        <meta name="description" content="jquery-cookie - A simple, lightweight utility plugin for reading, writing and deleting cookies." />
    <script type="text/javascript">
      GitHub.nameWithOwner = GitHub.nameWithOwner || "carhartl/jquery-cookie";
      GitHub.currentRef = 'master';
      GitHub.commitSHA = "67fb34f6a866c40d0570265e8fa5911605d92616";
      GitHub.currentPath = 'jquery.cookie.js';
      GitHub.masterBranch = "master";

      
    </script>
  

        <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-3769691-2']);
      _gaq.push(['_setDomainName', 'none']);
      _gaq.push(['_trackPageview']);
      _gaq.push(['_trackPageLoadTime']);
      (function() {
        var ga = document.createElement('script');
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        ga.setAttribute('async', 'true');
        document.documentElement.firstChild.appendChild(ga);
      })();
    </script>

    
  </head>

  

  <body class="logged_in page-blob  linux env-production">
    

    

    
      <div id="site_alert">
        <p>
          GitHub will switch to English-only on May 20, 2011.
          <a href="https://gist.github.com/a4b4fac18beb08335919">More info</a> |
          <a href="?locale=en">Switch to English now</a>
        </p>
      </div>
    

    

    

    

    <div class="subnavd" id="main">
      <div id="header" class="true">
        
          <a class="logo boring" href="https://github.com/">
            <img alt="github" class="default" src="https://d3nwyuy0nl342s.cloudfront.net/images/modules/header/logov3.png" />
            <!--[if (gt IE 8)|!(IE)]><!-->
            <img alt="github" class="hover" src="https://d3nwyuy0nl342s.cloudfront.net/images/modules/header/logov3-hover.png" />
            <!--<![endif]-->
          </a>
        
        
          





  
    <div class="userbox">
      <div class="avatarname">
        <a href="https://github.com/jacekkromskipolcode"><img src="https://secure.gravatar.com/avatar/4ec75cd49898138c56796064538f8f83?s=140&d=https://d3nwyuy0nl342s.cloudfront.net%2Fimages%2Fgravatars%2Fgravatar-140.png" alt="" width="20" height="20"  /></a>
        <a href="https://github.com/jacekkromskipolcode" class="name">jacekkromskipolcode</a>

        
        
      </div>
      <ul class="usernav">
        <li><a href="https://github.com/">Kokpit</a></li>
        <li>
          
          <a href="https://github.com/inbox">Inbox</a>
          <a href="https://github.com/inbox" class="unread_count ">0</a>
        </li>
        <li><a href="https://github.com/account">Ustawienia Konta</a></li>
                <li><a href="/logout">Wyloguj się</a></li>
      </ul>
    </div><!-- /.userbox -->
  


        
        <div class="topsearch">
  
    <form action="/search" id="top_search_form" method="get">
      <a href="/search" class="advanced-search tooltipped downwards" title="Advanced Search">Advanced Search</a>
      <input type="search" class="search my_repos_autocompleter" name="q" results="5" placeholder="Szukaj&hellip;" /> <input type="submit" value="Search" class="button" />
      <input type="hidden" name="type" value="Everything" />
      <input type="hidden" name="repo" value="" />
      <input type="hidden" name="langOverride" value="" />
      <input type="hidden" name="start_value" value="1" />
    </form>
    <ul class="nav">
      <li><a href="/explore">Przeglądaj GitHub'a</a></li>
      <li><a href="https://gist.github.com">Gist</a></li>
      <li><a href="/blog">Blog</a></li>
      <li><a href="http://help.github.com">Pomoc</a></li>
    </ul>
  
</div>

      </div>

      
      
        
    <div class="site">
      <div class="pagehead repohead vis-public    instapaper_ignore readability-menu">

      

      <div class="title-actions-bar">
        <h1>
          <a href="/carhartl">carhartl</a> / <strong><a href="/carhartl/jquery-cookie">jquery-cookie</a></strong>
          
          
        </h1>

        
    <ul class="actions">
      

      
        <li class="for-owner" style="display:none"><a href="/carhartl/jquery-cookie/admin" class="minibutton btn-admin "><span><span class="icon"></span>Admin</span></a></li>
        <li>
          <a href="/carhartl/jquery-cookie/toggle_watch" class="minibutton btn-watch " id="watch_button" onclick="var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'POST'; f.action = this.href;var s = document.createElement('input'); s.setAttribute('type', 'hidden'); s.setAttribute('name', 'authenticity_token'); s.setAttribute('value', '5fd252a3ece72236d6e7d60911bf7488c0db8dce'); f.appendChild(s);f.submit();return false;" style="display:none"><span><span class="icon"></span>Obserwuj</span></a>
          <a href="/carhartl/jquery-cookie/toggle_watch" class="minibutton btn-watch " id="unwatch_button" onclick="var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'POST'; f.action = this.href;var s = document.createElement('input'); s.setAttribute('type', 'hidden'); s.setAttribute('name', 'authenticity_token'); s.setAttribute('value', '5fd252a3ece72236d6e7d60911bf7488c0db8dce'); f.appendChild(s);f.submit();return false;" style="display:none"><span><span class="icon"></span>Przestań obserwować</span></a>
        </li>
        
          
            <li class="for-notforked" style="display:none"><a href="/carhartl/jquery-cookie/fork" class="minibutton btn-fork " id="fork_button" onclick="var f = document.createElement('form'); f.style.display = 'none'; this.parentNode.appendChild(f); f.method = 'POST'; f.action = this.href;var s = document.createElement('input'); s.setAttribute('type', 'hidden'); s.setAttribute('name', 'authenticity_token'); s.setAttribute('value', '5fd252a3ece72236d6e7d60911bf7488c0db8dce'); f.appendChild(s);f.submit();return false;"><span><span class="icon"></span>Fork</span></a></li>
            <li class="for-hasfork" style="display:none"><a href="#" class="minibutton btn-fork " id="your_fork_button"><span><span class="icon"></span>Twoja kopia</span></a></li>
          

          <li id='pull_request_item' class='nspr' style='display:none'><a href="/carhartl/jquery-cookie/pull/new/master" class="minibutton btn-pull-request "><span><span class="icon"></span>Pull Request</span></a></li>
        
      
      
      <li class="repostats">
        <ul class="repo-stats">
          <li class="watchers"><a href="/carhartl/jquery-cookie/watchers" title="Watchers" class="tooltipped downwards">261</a></li>
          <li class="forks"><a href="/carhartl/jquery-cookie/network" title="Forks" class="tooltipped downwards">15</a></li>
        </ul>
      </li>
    </ul>

      </div>

        
  <ul class="tabs">
    <li><a href="/carhartl/jquery-cookie" class="selected" highlight="repo_source">Źródło</a></li>
    <li><a href="/carhartl/jquery-cookie/commits/master" highlight="repo_commits">Commity</a></li>
    <li><a href="/carhartl/jquery-cookie/network" highlight="repo_network">Sieć</a></li>
    <li><a href="/carhartl/jquery-cookie/pulls" highlight="repo_pulls">Pull Requesty (0)</a></li>

    

    
      
      <li><a href="/carhartl/jquery-cookie/issues" highlight="issues">Zgłoszenia (3)</a></li>
    

            
    <li><a href="/carhartl/jquery-cookie/graphs" highlight="repo_graphs">Wykresy</a></li>

    <li class="contextswitch nochoices">
      <span class="toggle leftwards" >
        <em>Gałąź:</em>
        <code>master</code>
      </span>
    </li>
  </ul>

  <div style="display:none" id="pl-description"><p><em class="placeholder">kliknij tutaj aby dodać opis</em></p></div>
  <div style="display:none" id="pl-homepage"><p><em class="placeholder">kliknij tutaj aby dodać stronę domową</em></p></div>

  <div class="subnav-bar">
  
  <ul>
    <li>
      
      <a href="/carhartl/jquery-cookie/branches" class="dropdown">Zmień gałąź (1)</a>
      <ul>
        
          
            <li><strong>master &#x2713;</strong></li>
            
      </ul>
    </li>
    <li>
      <a href="#" class="dropdown defunct">Przełącz tagi (0)</a>
      
    </li>
    <li>
    
    <a href="/carhartl/jquery-cookie/branches" class="manage">Lista gałęzi</a>
    
    </li>
  </ul>
</div>

  
  
  
  
  
  



        
    <div id="repo_details" class="metabox clearfix">
      <div id="repo_details_loader" class="metabox-loader" style="display:none">Sending Request&hellip;</div>

        <a href="/carhartl/jquery-cookie/downloads" class="download-source" id="download_button" title="Download source, tagged packages and binaries."><span class="icon"></span>Pliki do pobrania</a>

      <div id="repository_desc_wrapper">
      <div id="repository_description" rel="repository_description_edit">
        
          <p>A simple, lightweight utility plugin for reading, writing and deleting cookies.
            <span id="read_more" style="display:none">&mdash; <a href="#readme">Read more</a></span>
          </p>
        
      </div>

      <div id="repository_description_edit" style="display:none;" class="inline-edit">
        <form action="/carhartl/jquery-cookie/admin/update" method="post"><div style="margin:0;padding:0"><input name="authenticity_token" type="hidden" value="5fd252a3ece72236d6e7d60911bf7488c0db8dce" /></div>
          <input type="hidden" name="field" value="repository_description">
          <input type="text" class="textfield" name="value" value="A simple, lightweight utility plugin for reading, writing and deleting cookies.">
          <div class="form-actions">
            <button class="minibutton"><span>Zapisz</span></button> &nbsp; <a href="#" class="cancel">anuluj</a>
          </div>
        </form>
      </div>

      
      <div class="repository-homepage" id="repository_homepage" rel="repository_homepage_edit">
        <p><a href="http://" rel="nofollow"></a></p>
      </div>

      <div id="repository_homepage_edit" style="display:none;" class="inline-edit">
        <form action="/carhartl/jquery-cookie/admin/update" method="post"><div style="margin:0;padding:0"><input name="authenticity_token" type="hidden" value="5fd252a3ece72236d6e7d60911bf7488c0db8dce" /></div>
          <input type="hidden" name="field" value="repository_homepage">
          <input type="text" class="textfield" name="value" value="">
          <div class="form-actions">
            <button class="minibutton"><span>Zapisz</span></button> &nbsp; <a href="#" class="cancel">anuluj</a>
          </div>
        </form>
      </div>
      </div>
      <div class="rule "></div>
      <div id="url_box" class="url-box">
  

  <ul class="clone-urls">
    
      
      <li id="http_clone_url"><a href="https://github.com/carhartl/jquery-cookie.git" data-permissions="Tylko do odczytu">HTTP</a></li>
      <li id="public_clone_url"><a href="git://github.com/carhartl/jquery-cookie.git" data-permissions="Tylko do odczytu">Git (Tylko do oczytu)</a></li>
    
    
  </ul>
  <input type="text" spellcheck="false" id="url_field" class="url-field" />
        <span style="display:none" id="url_box_clippy"></span>
      <span id="clippy_tooltip_url_box_clippy" class="clippy-tooltip tooltipped" title="copy to clipboard">
      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
              width="14"
              height="14"
              class="clippy"
              id="clippy" >
      <param name="movie" value="https://d3nwyuy0nl342s.cloudfront.net/flash/clippy.swf?v5"/>
      <param name="allowScriptAccess" value="always" />
      <param name="quality" value="high" />
      <param name="scale" value="noscale" />
      <param NAME="FlashVars" value="id=url_box_clippy&amp;copied=&amp;copyto=">
      <param name="bgcolor" value="#FFFFFF">
      <param name="wmode" value="opaque">
      <embed src="https://d3nwyuy0nl342s.cloudfront.net/flash/clippy.swf?v5"
             width="14"
             height="14"
             name="clippy"
             quality="high"
             allowScriptAccess="always"
             type="application/x-shockwave-flash"
             pluginspage="http://www.macromedia.com/go/getflashplayer"
             FlashVars="id=url_box_clippy&amp;copied=&amp;copyto="
             bgcolor="#FFFFFF"
             wmode="opaque"
      />
      </object>
      </span>

  <p id="url_description">Ten adres ma prawo do Odczytu+Zapisu</p>
</div>
    </div>

    <div class="frame frame-center tree-finder" style="display:none">
      <div class="breadcrumb">
        <b><a href="/carhartl/jquery-cookie">jquery-cookie</a></b> /
        <input class="tree-finder-input" type="text" name="query" autocomplete="off" spellcheck="false">
      </div>

      
        <div class="octotip">
          <p>
            <a href="/carhartl/jquery-cookie/dismiss-tree-finder-help" class="dismiss js-dismiss-tree-list-help" title="Hide this notice forever">Dismiss</a>
            <strong>Octotip:</strong> You've activated the <em>file finder</em> by pressing <span class="kbd">t</span>
            Start typing to filter the file list. Use <span class="kbd badmono">↑</span> and <span class="kbd badmono">↓</span> to navigate,
            <span class="kbd">enter</span> to view files.
          </p>
        </div>
      

      <table class="tree-browser" cellpadding="0" cellspacing="0">
        <tr class="js-header"><th>&nbsp;</th><th>name</th></tr>
        <tr class="js-no-results no-results" style="display: none">
          <th colspan="2">No matching files</th>
        </tr>
        <tbody class="js-results-list">
        </tbody>
      </table>
    </div>

    <div id="jump-to-line" style="display:none">
      <h2>Jump to Line</h2>
      <form>
        <input class="textfield" type="text">
        <div class="full-button">
          <button type="submit" class="classy">
            <span>Go</span>
          </button>
        </div>
      </form>
    </div>


        

      </div><!-- /.pagehead -->

      

  







<script type="text/javascript">
  GitHub.downloadRepo = '/carhartl/jquery-cookie/archives/master'
  GitHub.revType = "master"

  GitHub.repoName = "jquery-cookie"
  GitHub.controllerName = "blob"
  GitHub.actionName     = "show"
  GitHub.currentAction  = "blob#show"

  
    GitHub.loggedIn = true
    GitHub.hasWriteAccess = false
    GitHub.hasAdminAccess = false
    GitHub.watchingRepo = false
    GitHub.ignoredRepo = false
    GitHub.hasForkOfRepo = ""
    GitHub.hasForked = false
  

  
</script>






<div class="flash-messages"></div>


  <div id="commit">
    <div class="group">
        
  <div class="envelope commit">
    <div class="human">
      
        <div class="message"><pre><a href="/carhartl/jquery-cookie/commit/67fb34f6a866c40d0570265e8fa5911605d92616">not a todo</a> </pre></div>
      

      <div class="actor">
        <div class="gravatar">
          
          <img src="https://secure.gravatar.com/avatar/ae8c6ae27f6b9d5707bc5a32d0fb21a6?s=140&d=https://d3nwyuy0nl342s.cloudfront.net%2Fimages%2Fgravatars%2Fgravatar-140.png" alt="" width="30" height="30"  />
        </div>
        <div class="name"><a href="/carhartl">carhartl</a> <span>(author)</span></div>
        <div class="date">
          <abbr class="relatize" title="2011-01-27 02:55:09">Thu Jan 27 02:55:09 -0800 2011</abbr>
        </div>
      </div>

      

    </div>
    <div class="machine">
      <span>c</span>ommit&nbsp;&nbsp;<a href="/carhartl/jquery-cookie/commit/67fb34f6a866c40d0570265e8fa5911605d92616" hotkey="c">67fb34f6a866c40d0570</a><br />
      <span>d</span>rzewo&nbsp;&nbsp;<a href="/carhartl/jquery-cookie/tree/67fb34f6a866c40d0570265e8fa5911605d92616" hotkey="t">88dcbe69dd4b20d72999</a><br />
      
        <span>r</span>odzic&nbsp;
        
        <a href="/carhartl/jquery-cookie/tree/001687708c9270d399eea2d0c4c10fd6b0169b3e" hotkey="p">001687708c9270d399ee</a>
      

    </div>
  </div>

    </div>
  </div>



  <div id="slider">

  

    <div class="breadcrumb" data-path="jquery.cookie.js/">
      <b><a href="/carhartl/jquery-cookie/tree/67fb34f6a866c40d0570265e8fa5911605d92616">jquery-cookie</a></b> / jquery.cookie.js       <span style="display:none" id="clippy_811">jquery.cookie.js</span>
      
      <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
              width="110"
              height="14"
              class="clippy"
              id="clippy" >
      <param name="movie" value="https://d3nwyuy0nl342s.cloudfront.net/flash/clippy.swf?v5"/>
      <param name="allowScriptAccess" value="always" />
      <param name="quality" value="high" />
      <param name="scale" value="noscale" />
      <param NAME="FlashVars" value="id=clippy_811&amp;copied=copied!&amp;copyto=copy to clipboard">
      <param name="bgcolor" value="#FFFFFF">
      <param name="wmode" value="opaque">
      <embed src="https://d3nwyuy0nl342s.cloudfront.net/flash/clippy.swf?v5"
             width="110"
             height="14"
             name="clippy"
             quality="high"
             allowScriptAccess="always"
             type="application/x-shockwave-flash"
             pluginspage="http://www.macromedia.com/go/getflashplayer"
             FlashVars="id=clippy_811&amp;copied=copied!&amp;copyto=copy to clipboard"
             bgcolor="#FFFFFF"
             wmode="opaque"
      />
      </object>
      

    </div>

    <div class="frames">
      <div class="frame frame-center" data-path="jquery.cookie.js/" data-canonical-url="/carhartl/jquery-cookie/blob/67fb34f6a866c40d0570265e8fa5911605d92616/jquery.cookie.js">
        
          <ul class="big-actions">
            
            <li><a class="file-edit-link minibutton" href="/carhartl/jquery-cookie/file-edit/__current_ref__/jquery.cookie.js"><span>Edit this file</span></a></li>
          </ul>
        

        <div id="files">
          <div class="file">
            <div class="meta">
              <div class="info">
                <span class="icon"><img alt="Txt" height="16" src="https://d3nwyuy0nl342s.cloudfront.net/images/icons/txt.png" width="16" /></span>
                <span class="mode" title="File Mode">100644</span>
                
                  <span>92 lines (81 sloc)</span>
                
                <span>3.713 kb</span>
              </div>
              <ul class="actions">
                <li><a href="/carhartl/jquery-cookie/raw/master/jquery.cookie.js" id="raw-url">raw</a></li>
                
                  <li><a href="/carhartl/jquery-cookie/blame/master/jquery.cookie.js">blame</a></li>
                
                <li><a href="/carhartl/jquery-cookie/commits/master/jquery.cookie.js">history</a></li>
              </ul>
            </div>
            
  <div class="data type-javascript">
    
      <table cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <pre class="line_numbers"><span id="L1" rel="#L1">1</span>
<span id="L2" rel="#L2">2</span>
<span id="L3" rel="#L3">3</span>
<span id="L4" rel="#L4">4</span>
<span id="L5" rel="#L5">5</span>
<span id="L6" rel="#L6">6</span>
<span id="L7" rel="#L7">7</span>
<span id="L8" rel="#L8">8</span>
<span id="L9" rel="#L9">9</span>
<span id="L10" rel="#L10">10</span>
<span id="L11" rel="#L11">11</span>
<span id="L12" rel="#L12">12</span>
<span id="L13" rel="#L13">13</span>
<span id="L14" rel="#L14">14</span>
<span id="L15" rel="#L15">15</span>
<span id="L16" rel="#L16">16</span>
<span id="L17" rel="#L17">17</span>
<span id="L18" rel="#L18">18</span>
<span id="L19" rel="#L19">19</span>
<span id="L20" rel="#L20">20</span>
<span id="L21" rel="#L21">21</span>
<span id="L22" rel="#L22">22</span>
<span id="L23" rel="#L23">23</span>
<span id="L24" rel="#L24">24</span>
<span id="L25" rel="#L25">25</span>
<span id="L26" rel="#L26">26</span>
<span id="L27" rel="#L27">27</span>
<span id="L28" rel="#L28">28</span>
<span id="L29" rel="#L29">29</span>
<span id="L30" rel="#L30">30</span>
<span id="L31" rel="#L31">31</span>
<span id="L32" rel="#L32">32</span>
<span id="L33" rel="#L33">33</span>
<span id="L34" rel="#L34">34</span>
<span id="L35" rel="#L35">35</span>
<span id="L36" rel="#L36">36</span>
<span id="L37" rel="#L37">37</span>
<span id="L38" rel="#L38">38</span>
<span id="L39" rel="#L39">39</span>
<span id="L40" rel="#L40">40</span>
<span id="L41" rel="#L41">41</span>
<span id="L42" rel="#L42">42</span>
<span id="L43" rel="#L43">43</span>
<span id="L44" rel="#L44">44</span>
<span id="L45" rel="#L45">45</span>
<span id="L46" rel="#L46">46</span>
<span id="L47" rel="#L47">47</span>
<span id="L48" rel="#L48">48</span>
<span id="L49" rel="#L49">49</span>
<span id="L50" rel="#L50">50</span>
<span id="L51" rel="#L51">51</span>
<span id="L52" rel="#L52">52</span>
<span id="L53" rel="#L53">53</span>
<span id="L54" rel="#L54">54</span>
<span id="L55" rel="#L55">55</span>
<span id="L56" rel="#L56">56</span>
<span id="L57" rel="#L57">57</span>
<span id="L58" rel="#L58">58</span>
<span id="L59" rel="#L59">59</span>
<span id="L60" rel="#L60">60</span>
<span id="L61" rel="#L61">61</span>
<span id="L62" rel="#L62">62</span>
<span id="L63" rel="#L63">63</span>
<span id="L64" rel="#L64">64</span>
<span id="L65" rel="#L65">65</span>
<span id="L66" rel="#L66">66</span>
<span id="L67" rel="#L67">67</span>
<span id="L68" rel="#L68">68</span>
<span id="L69" rel="#L69">69</span>
<span id="L70" rel="#L70">70</span>
<span id="L71" rel="#L71">71</span>
<span id="L72" rel="#L72">72</span>
<span id="L73" rel="#L73">73</span>
<span id="L74" rel="#L74">74</span>
<span id="L75" rel="#L75">75</span>
<span id="L76" rel="#L76">76</span>
<span id="L77" rel="#L77">77</span>
<span id="L78" rel="#L78">78</span>
<span id="L79" rel="#L79">79</span>
<span id="L80" rel="#L80">80</span>
<span id="L81" rel="#L81">81</span>
<span id="L82" rel="#L82">82</span>
<span id="L83" rel="#L83">83</span>
<span id="L84" rel="#L84">84</span>
<span id="L85" rel="#L85">85</span>
<span id="L86" rel="#L86">86</span>
<span id="L87" rel="#L87">87</span>
<span id="L88" rel="#L88">88</span>
<span id="L89" rel="#L89">89</span>
<span id="L90" rel="#L90">90</span>
<span id="L91" rel="#L91">91</span>
<span id="L92" rel="#L92">92</span>
</pre>
          </td>
          <td width="100%">
            
              
                <div class="highlight"><pre><div class='line' id='LC1'><span class="cm">/*jslint browser: true */</span> <span class="cm">/*global jQuery: true */</span></div><div class='line' id='LC2'><br/></div><div class='line' id='LC3'><span class="cm">/**</span></div><div class='line' id='LC4'><span class="cm"> * jQuery Cookie plugin</span></div><div class='line' id='LC5'><span class="cm"> *</span></div><div class='line' id='LC6'><span class="cm"> * Copyright (c) 2010 Klaus Hartl (stilbuero.de)</span></div><div class='line' id='LC7'><span class="cm"> * Dual licensed under the MIT and GPL licenses:</span></div><div class='line' id='LC8'><span class="cm"> * http://www.opensource.org/licenses/mit-license.php</span></div><div class='line' id='LC9'><span class="cm"> * http://www.gnu.org/licenses/gpl.html</span></div><div class='line' id='LC10'><span class="cm"> *</span></div><div class='line' id='LC11'><span class="cm"> */</span></div><div class='line' id='LC12'><br/></div><div class='line' id='LC13'><span class="c1">// TODO JsDoc</span></div><div class='line' id='LC14'><br/></div><div class='line' id='LC15'><span class="cm">/**</span></div><div class='line' id='LC16'><span class="cm"> * Create a cookie with the given key and value and other optional parameters.</span></div><div class='line' id='LC17'><span class="cm"> *</span></div><div class='line' id='LC18'><span class="cm"> * @example $.cookie(&#39;the_cookie&#39;, &#39;the_value&#39;);</span></div><div class='line' id='LC19'><span class="cm"> * @desc Set the value of a cookie.</span></div><div class='line' id='LC20'><span class="cm"> * @example $.cookie(&#39;the_cookie&#39;, &#39;the_value&#39;, { expires: 7, path: &#39;/&#39;, domain: &#39;jquery.com&#39;, secure: true });</span></div><div class='line' id='LC21'><span class="cm"> * @desc Create a cookie with all available options.</span></div><div class='line' id='LC22'><span class="cm"> * @example $.cookie(&#39;the_cookie&#39;, &#39;the_value&#39;);</span></div><div class='line' id='LC23'><span class="cm"> * @desc Create a session cookie.</span></div><div class='line' id='LC24'><span class="cm"> * @example $.cookie(&#39;the_cookie&#39;, null);</span></div><div class='line' id='LC25'><span class="cm"> * @desc Delete a cookie by passing null as value. Keep in mind that you have to use the same path and domain</span></div><div class='line' id='LC26'><span class="cm"> *       used when the cookie was set.</span></div><div class='line' id='LC27'><span class="cm"> *</span></div><div class='line' id='LC28'><span class="cm"> * @param String key The key of the cookie.</span></div><div class='line' id='LC29'><span class="cm"> * @param String value The value of the cookie.</span></div><div class='line' id='LC30'><span class="cm"> * @param Object options An object literal containing key/value pairs to provide optional cookie attributes.</span></div><div class='line' id='LC31'><span class="cm"> * @option Number|Date expires Either an integer specifying the expiration date from now on in days or a Date object.</span></div><div class='line' id='LC32'><span class="cm"> *                             If a negative value is specified (e.g. a date in the past), the cookie will be deleted.</span></div><div class='line' id='LC33'><span class="cm"> *                             If set to null or omitted, the cookie will be a session cookie and will not be retained</span></div><div class='line' id='LC34'><span class="cm"> *                             when the the browser exits.</span></div><div class='line' id='LC35'><span class="cm"> * @option String path The value of the path atribute of the cookie (default: path of page that created the cookie).</span></div><div class='line' id='LC36'><span class="cm"> * @option String domain The value of the domain attribute of the cookie (default: domain of page that created the cookie).</span></div><div class='line' id='LC37'><span class="cm"> * @option Boolean secure If true, the secure attribute of the cookie will be set and the cookie transmission will</span></div><div class='line' id='LC38'><span class="cm"> *                        require a secure protocol (like HTTPS).</span></div><div class='line' id='LC39'><span class="cm"> * @type undefined</span></div><div class='line' id='LC40'><span class="cm"> *</span></div><div class='line' id='LC41'><span class="cm"> * @name $.cookie</span></div><div class='line' id='LC42'><span class="cm"> * @cat Plugins/Cookie</span></div><div class='line' id='LC43'><span class="cm"> * @author Klaus Hartl/klaus.hartl@stilbuero.de</span></div><div class='line' id='LC44'><span class="cm"> */</span></div><div class='line' id='LC45'><br/></div><div class='line' id='LC46'><span class="cm">/**</span></div><div class='line' id='LC47'><span class="cm"> * Get the value of a cookie with the given key.</span></div><div class='line' id='LC48'><span class="cm"> *</span></div><div class='line' id='LC49'><span class="cm"> * @example $.cookie(&#39;the_cookie&#39;);</span></div><div class='line' id='LC50'><span class="cm"> * @desc Get the value of a cookie.</span></div><div class='line' id='LC51'><span class="cm"> *</span></div><div class='line' id='LC52'><span class="cm"> * @param String key The key of the cookie.</span></div><div class='line' id='LC53'><span class="cm"> * @return The value of the cookie.</span></div><div class='line' id='LC54'><span class="cm"> * @type String</span></div><div class='line' id='LC55'><span class="cm"> *</span></div><div class='line' id='LC56'><span class="cm"> * @name $.cookie</span></div><div class='line' id='LC57'><span class="cm"> * @cat Plugins/Cookie</span></div><div class='line' id='LC58'><span class="cm"> * @author Klaus Hartl/klaus.hartl@stilbuero.de</span></div><div class='line' id='LC59'><span class="cm"> */</span></div><div class='line' id='LC60'><span class="nx">jQuery</span><span class="p">.</span><span class="nx">cookie</span> <span class="o">=</span> <span class="kd">function</span> <span class="p">(</span><span class="nx">key</span><span class="p">,</span> <span class="nx">value</span><span class="p">,</span> <span class="nx">options</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC61'>&nbsp;&nbsp;&nbsp;&nbsp;</div><div class='line' id='LC62'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// key and at least value given, set cookie...</span></div><div class='line' id='LC63'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">if</span> <span class="p">(</span><span class="nx">arguments</span><span class="p">.</span><span class="nx">length</span> <span class="o">&gt;</span> <span class="mi">1</span> <span class="o">&amp;&amp;</span> <span class="nb">String</span><span class="p">(</span><span class="nx">value</span><span class="p">)</span> <span class="o">!==</span> <span class="s2">&quot;[object Object]&quot;</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC64'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">options</span> <span class="o">=</span> <span class="nx">jQuery</span><span class="p">.</span><span class="nx">extend</span><span class="p">({},</span> <span class="nx">options</span><span class="p">);</span></div><div class='line' id='LC65'><br/></div><div class='line' id='LC66'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">if</span> <span class="p">(</span><span class="nx">value</span> <span class="o">===</span> <span class="kc">null</span> <span class="o">||</span> <span class="nx">value</span> <span class="o">===</span> <span class="kc">undefined</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC67'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">options</span><span class="p">.</span><span class="nx">expires</span> <span class="o">=</span> <span class="o">-</span><span class="mi">1</span><span class="p">;</span></div><div class='line' id='LC68'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span></div><div class='line' id='LC69'><br/></div><div class='line' id='LC70'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">if</span> <span class="p">(</span><span class="k">typeof</span> <span class="nx">options</span><span class="p">.</span><span class="nx">expires</span> <span class="o">===</span> <span class="s1">&#39;number&#39;</span><span class="p">)</span> <span class="p">{</span></div><div class='line' id='LC71'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="kd">var</span> <span class="nx">days</span> <span class="o">=</span> <span class="nx">options</span><span class="p">.</span><span class="nx">expires</span><span class="p">,</span> <span class="nx">t</span> <span class="o">=</span> <span class="nx">options</span><span class="p">.</span><span class="nx">expires</span> <span class="o">=</span> <span class="k">new</span> <span class="nb">Date</span><span class="p">();</span></div><div class='line' id='LC72'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">t</span><span class="p">.</span><span class="nx">setDate</span><span class="p">(</span><span class="nx">t</span><span class="p">.</span><span class="nx">getDate</span><span class="p">()</span> <span class="o">+</span> <span class="nx">days</span><span class="p">);</span></div><div class='line' id='LC73'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span></div><div class='line' id='LC74'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><div class='line' id='LC75'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">value</span> <span class="o">=</span> <span class="nb">String</span><span class="p">(</span><span class="nx">value</span><span class="p">);</span></div><div class='line' id='LC76'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><div class='line' id='LC77'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">return</span> <span class="p">(</span><span class="nb">document</span><span class="p">.</span><span class="nx">cookie</span> <span class="o">=</span> <span class="p">[</span></div><div class='line' id='LC78'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nb">encodeURIComponent</span><span class="p">(</span><span class="nx">key</span><span class="p">),</span> <span class="s1">&#39;=&#39;</span><span class="p">,</span></div><div class='line' id='LC79'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">options</span><span class="p">.</span><span class="nx">raw</span> <span class="o">?</span> <span class="nx">value</span> <span class="o">:</span> <span class="nb">encodeURIComponent</span><span class="p">(</span><span class="nx">value</span><span class="p">),</span></div><div class='line' id='LC80'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">options</span><span class="p">.</span><span class="nx">expires</span> <span class="o">?</span> <span class="s1">&#39;; expires=&#39;</span> <span class="o">+</span> <span class="nx">options</span><span class="p">.</span><span class="nx">expires</span><span class="p">.</span><span class="nx">toUTCString</span><span class="p">()</span> <span class="o">:</span> <span class="s1">&#39;&#39;</span><span class="p">,</span> <span class="c1">// use expires attribute, max-age is not supported by IE</span></div><div class='line' id='LC81'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">options</span><span class="p">.</span><span class="nx">path</span> <span class="o">?</span> <span class="s1">&#39;; path=&#39;</span> <span class="o">+</span> <span class="nx">options</span><span class="p">.</span><span class="nx">path</span> <span class="o">:</span> <span class="s1">&#39;&#39;</span><span class="p">,</span></div><div class='line' id='LC82'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">options</span><span class="p">.</span><span class="nx">domain</span> <span class="o">?</span> <span class="s1">&#39;; domain=&#39;</span> <span class="o">+</span> <span class="nx">options</span><span class="p">.</span><span class="nx">domain</span> <span class="o">:</span> <span class="s1">&#39;&#39;</span><span class="p">,</span></div><div class='line' id='LC83'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">options</span><span class="p">.</span><span class="nx">secure</span> <span class="o">?</span> <span class="s1">&#39;; secure&#39;</span> <span class="o">:</span> <span class="s1">&#39;&#39;</span></div><div class='line' id='LC84'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">].</span><span class="nx">join</span><span class="p">(</span><span class="s1">&#39;&#39;</span><span class="p">));</span></div><div class='line' id='LC85'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="p">}</span></div><div class='line' id='LC86'><br/></div><div class='line' id='LC87'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="c1">// key and possibly options given, get cookie...</span></div><div class='line' id='LC88'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="nx">options</span> <span class="o">=</span> <span class="nx">value</span> <span class="o">||</span> <span class="p">{};</span></div><div class='line' id='LC89'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="kd">var</span> <span class="nx">result</span><span class="p">,</span> <span class="nx">decode</span> <span class="o">=</span> <span class="nx">options</span><span class="p">.</span><span class="nx">raw</span> <span class="o">?</span> <span class="kd">function</span> <span class="p">(</span><span class="nx">s</span><span class="p">)</span> <span class="p">{</span> <span class="k">return</span> <span class="nx">s</span><span class="p">;</span> <span class="p">}</span> <span class="o">:</span> <span class="nb">decodeURIComponent</span><span class="p">;</span></div><div class='line' id='LC90'>&nbsp;&nbsp;&nbsp;&nbsp;<span class="k">return</span> <span class="p">(</span><span class="nx">result</span> <span class="o">=</span> <span class="k">new</span> <span class="nb">RegExp</span><span class="p">(</span><span class="s1">&#39;(?:^|; )&#39;</span> <span class="o">+</span> <span class="nb">encodeURIComponent</span><span class="p">(</span><span class="nx">key</span><span class="p">)</span> <span class="o">+</span> <span class="s1">&#39;=([^;]*)&#39;</span><span class="p">).</span><span class="nx">exec</span><span class="p">(</span><span class="nb">document</span><span class="p">.</span><span class="nx">cookie</span><span class="p">))</span> <span class="o">?</span> <span class="nx">decode</span><span class="p">(</span><span class="nx">result</span><span class="p">[</span><span class="mi">1</span><span class="p">])</span> <span class="o">:</span> <span class="kc">null</span><span class="p">;</span></div><div class='line' id='LC91'><span class="p">};</span></div><div class='line' id='LC92'><br/></div></pre></div>
              
            
          </td>
        </tr>
      </table>
    
  </div>


          </div>
        </div>
      </div>
    </div>
  

  </div>


<div class="frame frame-loading" style="display:none;">
  <img src="https://d3nwyuy0nl342s.cloudfront.net/images/modules/ajax/big_spinner_336699.gif" height="32" width="32">
</div>

    </div>
  
      
    </div>

    <div id="footer" class="clearfix">
      <div class="site">
        <div class="sponsor">
          <a href="http://www.rackspace.com" class="logo">
            <img alt="Dedicated Server" height="36" src="https://d3nwyuy0nl342s.cloudfront.net/images/modules/footer/rackspace_logo.png?v2" width="38" />
          </a>
          Powered by the <a href="http://www.rackspace.com ">Dedicated
          Servers</a> and<br/> <a href="http://www.rackspacecloud.com">Cloud
          Computing</a> of Rackspace Hosting<span>&reg;</span>
        </div>

        <ul class="links">
          <li class="blog"><a href="https://github.com/blog">Blog</a></li>
          <li><a href="https://github.com/contact">Wsparcie</a></li>
          <li><a href="https://github.com/training">Szkolenia</a></li>
          <li><a href="http://jobs.github.com">Job Board</a></li>
          <li><a href="http://shop.github.com">Shop</a></li>
          <li><a href="https://github.com/contact">Kontakt</a></li>
          <li><a href="http://developer.github.com">API</a></li>
          <li><a href="http://status.github.com">Status</a></li>
        </ul>
        <ul class="sosueme">
          <li class="main">&copy; 2011 <span id="_rrt" title="0.11131s from fe2.rs.github.com">GitHub</span> Inc. All rights reserved.</li>
          <li><a href="/site/terms">Regulamin</a></li>
          <li><a href="/site/privacy">Polityka prywatności</a></li>
          <li><a href="https://github.com/security">Bezpieczeństwo</a></li>
        </ul>
      </div>
    </div><!-- /#footer -->

    <script>window._auth_token = "5fd252a3ece72236d6e7d60911bf7488c0db8dce"</script>
    

<div id="keyboard_shortcuts_pane" class="instapaper_ignore readability-extra" style="display:none">
  <h2>Keyboard Shortcuts <small><a href="#" class="js-see-all-keyboard-shortcuts">(see all)</a></small></h2>

  <div class="columns threecols">
    <div class="column first">
      <h3>Site wide shortcuts</h3>
      <dl class="keyboard-mappings">
        <dt>s</dt>
        <dd>Focus site search</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>?</dt>
        <dd>Bring up this help dialog</dd>
      </dl>
    </div><!-- /.column.first -->

    <div class="column middle" style='display:none'>
      <h3>Commit list</h3>
      <dl class="keyboard-mappings">
        <dt>j</dt>
        <dd>Move selected down</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>k</dt>
        <dd>Move selected up</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>t</dt>
        <dd>Open tree</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>p</dt>
        <dd>Open parent</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>c <em>or</em> o <em>or</em> enter</dt>
        <dd>Open commit</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>y</dt>
        <dd>Expand URL to its canonical form</dd>
      </dl>
    </div><!-- /.column.first -->

    <div class="column last" style='display:none'>
      <h3>Pull request list</h3>
      <dl class="keyboard-mappings">
        <dt>j</dt>
        <dd>Move selected down</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>k</dt>
        <dd>Move selected up</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>o <em>or</em> enter</dt>
        <dd>Open issue</dd>
      </dl>
    </div><!-- /.columns.last -->

  </div><!-- /.columns.equacols -->

  <div style='display:none'>
    <div class="rule"></div>

    <h3>Issues</h3>

    <div class="columns threecols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt>j</dt>
          <dd>Move selected down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>k</dt>
          <dd>Move selected up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>x</dt>
          <dd>Toggle select target</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>o <em>or</em> enter</dt>
          <dd>Open issue</dd>
        </dl>
      </div><!-- /.column.first -->
      <div class="column middle">
        <dl class="keyboard-mappings">
          <dt>I</dt>
          <dd>Mark selected as read</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>U</dt>
          <dd>Mark selected as unread</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>e</dt>
          <dd>Close selected</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>y</dt>
          <dd>Remove selected from view</dd>
        </dl>
      </div><!-- /.column.middle -->
      <div class="column last">
        <dl class="keyboard-mappings">
          <dt>c</dt>
          <dd>Create issue</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>l</dt>
          <dd>Create label</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>i</dt>
          <dd>Back to inbox</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>u</dt>
          <dd>Back to issues</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>/</dt>
          <dd>Focus issues search</dd>
        </dl>
      </div>
    </div>
  </div>

  <div style='display:none'>
    <div class="rule"></div>

    <h3>Network Graph</h3>
    <div class="columns equacols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt><span class="badmono">←</span> <em>or</em> h</dt>
          <dd>Scroll left</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">→</span> <em>or</em> l</dt>
          <dd>Scroll right</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">↑</span> <em>or</em> k</dt>
          <dd>Scroll up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">↓</span> <em>or</em> j</dt>
          <dd>Scroll down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>t</dt>
          <dd>Toggle visibility of head labels</dd>
        </dl>
      </div><!-- /.column.first -->
      <div class="column last">
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">←</span> <em>or</em> shift h</dt>
          <dd>Scroll all the way left</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">→</span> <em>or</em> shift l</dt>
          <dd>Scroll all the way right</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">↑</span> <em>or</em> shift k</dt>
          <dd>Scroll all the way up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">↓</span> <em>or</em> shift j</dt>
          <dd>Scroll all the way down</dd>
        </dl>
      </div><!-- /.column.last -->
    </div>
  </div>

  <div >
    <div class="rule"></div>
    <div class="columns threecols">
      <div class="column first" >
        <h3>Source Code Browsing</h3>
        <dl class="keyboard-mappings">
          <dt>t</dt>
          <dd>Activates the file finder</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>l</dt>
          <dd>Jump to line</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>y</dt>
          <dd>Expand URL to its canonical form</dd>
        </dl>
      </div>
    </div>
  </div>
</div>

    <div id="markdown-help" class="instapaper_ignore readability-extra">
  <h2>Markdown Cheat Sheet</h2>

  <div class="cheatsheet-content">

  <div class="mod">
    <div class="col">
      <h3>Format Text</h3>
      <p>Headers</p>
      <pre>
# This is an &lt;h1&gt; tag
## This is an &lt;h2&gt; tag
###### This is an &lt;h6&gt; tag</pre>
     <p>Text styles</p>
     <pre>
*This text will be italic*
_This will also be italic_
**This text will be bold**
__This will also be bold__

*You **can** combine them*
</pre>
    </div>
    <div class="col">
      <h3>Lists</h3>
      <p>Unordered</p>
      <pre>
* Item 1
* Item 2
  * Item 2a
  * Item 2b</pre>
     <p>Ordered</p>
     <pre>
1. Item 1
2. Item 2
3. Item 3
   * Item 3a
   * Item 3b</pre>
    </div>
    <div class="col">
      <h3>Miscellaneous</h3>
      <p>Images</p>
      <pre>
![GitHub Logo](/images/logo.png)
Format: ![Alt Text](url)
</pre>
     <p>Links</p>
     <pre>
http://github.com - automatic!
[GitHub](http://github.com)</pre>
<p>Blockquotes</p>
     <pre>
As Kanye West said:
> We're living the future so
> the present is our past.
</pre>
    </div>
  </div>
  <div class="rule"></div>

  <h3>Code Examples in Markdown</h3>
  <div class="col">
      <p>Syntax highlighting with <a href="http://github.github.com/github-flavored-markdown/" title="GitHub Flavored Markdown">GFM</a></p>
      <pre>
```javascript
function fancyAlert(arg) {
  if(arg) {
    $.facebox({div:'#foo'})
  }
}
```</pre>
    </div>
    <div class="col">
      <p>Or, indent your code 4 spaces</p>
      <pre>
Here is a Python code example
without syntax highlighting:

    def foo:
      if not bar:
        return true</pre>
    </div>
    <div class="col">
      <p>Inline code for comments</p>
      <pre>
I think you should use an
`&lt;addr&gt;` element here instead.</pre>
    </div>
  </div>

  </div>
</div>
    

    <!--[if IE 8]>
    <script type="text/javascript" charset="utf-8">
      $(document.body).addClass("ie8")
    </script>
    <![endif]-->

    <!--[if IE 7]>
    <script type="text/javascript" charset="utf-8">
      $(document.body).addClass("ie7")
    </script>
    <![endif]-->

    
    <script type='text/javascript'></script>
    
    <script type="text/javascript" charset="utf-8">NREUMQ.push(["nrf2","beacon-1.newrelic.com","2f94e4d8c2",64799,"dw1bEBZcX1RWRho0B1cJGiMNR3tNUQ4PNANEDWUBFl5aS0BdWggV",0.0,157])</script>
  </body>
</html>

