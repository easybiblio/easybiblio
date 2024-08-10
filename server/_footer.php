<?php
  $fmw->clearMessages();
?>
<footer class="pull-right">
    <font face="arial" size="-3">
        Powered by <a target="_blank" href="https://github.com/easybiblio">EasyBiblio</a>
    </font>
</footer>
    
    <script>
        function _changeLanguage(languageToSet) {
           $.get("_changeLanguage.php?_language=" + languageToSet, function(data,status) {
              location.reload(true);
           });
        }
    </script>

    <script src="js/bootstrap.min.js"></script>
</body>
</html>