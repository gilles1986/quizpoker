<h3>Editor</h3>
<p>Anzahl Fragen: {$questions|count}</p>
<ul class="questionList">
{foreach from=$questions item=question}
  <li>{include file="./questionStatus.tpl"}</li>
{/foreach}
</ul>