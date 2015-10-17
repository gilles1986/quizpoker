{if $question->hint1 == ''}
   {assign var="hint1Status" value="glyphicon glyphicon-remove"}
{else}
    {assign var="hint1Status" value="glyphicon glyphicon-ok"}
{/if}

{if $question->hint2 == ''}
    {assign var="hint2Status" value="glyphicon glyphicon-remove"}
{else}
    {assign var="hint2Status" value="glyphicon glyphicon-ok"}
{/if}

{if $question->answer == ''}
    {assign var="answer2Status" value="glyphicon glyphicon-remove"}
{else}
    {assign var="answer2Status" value="glyphicon glyphicon-ok"}
{/if}


<div class="table-responsive">
<table class="questions table table-bordered table-condensed">
    <tr>
        <th>Id</th>
        <th>Frage</th>
        <th>Hinweis 1</th>
        <th>Hinweis 2</th>
        <th>Antwort</th>
        <th>Löschen</th>
    </tr>
    <tr>
        <td>{$question->id}</td>
        <td class="span1 question"><a href="?action=editQuestion&id={$question->id}">{$question->question|escape}</a></td>
        <td class="span2"><span aria-hidden="true" class="{$hint1Status}"></span></td>
        <td class="span2"><span aria-hidden="true" class="{$hint2Status}"></span></td>
        <td class="span2"><span aria-hidden="true" class="{$answer2Status}"></span></td>
        <td class="span2"><a href="?action=deleteQuestion&id={$question->id}">Löschen</a></span></td>
    </tr>
</table>
</div>
