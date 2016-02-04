<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Autocomplete - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>







<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/bootstrap/js/bootstrap-tour.min.js"></script>
<script src="/assets/fancybox/jquery.fancybox.js"></script>
<script src="/assets/fancybox/helpers/jquery.fancybox-buttons.js"></script>
<script src="/assets/fancybox/helpers/jquery.fancybox-thumbs.js"></script>
<link rel="stylesheet" href="/assets/fancybox/helpers/jquery.fancybox-buttons.css">
<link rel="stylesheet" href="/assets/fancybox/helpers/jquery.fancybox-thumbs.css">
<link rel="stylesheet" href="/assets/fancybox/jquery.fancybox.css">

<script type="text/javascript" src="/assets/js/star-rating.min.js"></script>
<script type="text/javascript" src="/assets/js/jqcloud-1.0.4.min.js"></script>

<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="/assets/js/charts/highcharts.js"></script>

<script type="text/javascript" src="/assets/js/scripts.js"></script>
<script type="text/javascript" src="/assets/js/vote-script.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>




  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    var availableTags = [
      "ActionScript",
      "AppleScript",
      "Asp",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme"
    ];

$( "#tags" ).autocomplete({
      source: availableTags
    });
  });
  </script>
</head>
<body>
 
<div class="ui-widget">
  <label for="tags">Tags: </label>
  <input id="tags">
</div>
 
 
</body>
</html>
