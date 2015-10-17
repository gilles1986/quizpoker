<h2>Editor</h2>

{if $errors|@count > 0}
  Das Formular wurde nicht korrekt ausgefüllt
  <ul>
    {foreach $errors as $error}
      <li>{$error}</li>
    {/foreach}
  </ul>
{/if}

<form action="" >
  <input type="hidden" name="action" value="doEditQuestion"/>
  <input type="hidden" name="id" value="{$question->id}"/>
  <div class="form-group">
    <label for="question">Frage</label>
    <input type="text" id="question" name="question" value="{$question->question|escape}">
  </div>
  <div class="form-group">
    <label for="hint1">Hinweis 1</label>
    <input type="text" id="hint1" name="hint1" value="{$question->hint1|escape}">
  </div>
  <div class="form-group">
    <label for="hint2">Hinweis 2</label>
    <input type="text" id="hint2" name="hint2" value="{$question->hint2|escape}">
  </div>
  <div class="form-group">
    <label for="answer">Antwort</label>
    <input type="text" id="answer" name="answer" value="{$question->answer|escape}">
  </div>

  <input type="submit" class="btn btn-default" value="OK" />
</form>