<div id="contentWrapper" class="container">
 <div id="content">
 <h1 data-toggle="collapse" aria-controls="collapseNav" data-target="#collapseNav">Quiz Poker</h1>
     {if $showReload == true}<span class="glyphicon glyphicon-refresh break reloadButton"></span>{/if}

  <ul class="nav nav-tabs {$collapseNav}collapse" id="collapseNav" >
    <li><a href="?action=play">Spielen</a></li>
    <li><a href="?action=editQuestions">Editor</a></li>
    <li><a href="?action=addQuestions">Frage hinzufügen</a></li>
   </ul>
 {include file="../{$tpl[0]}/{$tpl[1]}.tpl"}
 </div>
</div>