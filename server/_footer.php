<?php
  $fmw->clearMessages();
?>
<footer class="pull-right">
    <font face="arial" size="-3">
        Powered by <a target="_blank" href="http://www.easybiblio.com">EasyBiblio.com</a>
    </font>
</footer>
    
    <script>
        function _changeLanguage(languageToSet) {
           $.get("_changeLanguage.php?_language=" + languageToSet, function(data,status) {
              // alert('language was set, reload URL here');
           });
        }
    </script>

    <script src="js/bootstrap.min.js"></script>
</body>
</html>