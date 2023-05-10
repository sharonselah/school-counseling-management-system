<style>




</style>

<div class="habits">
<p style="text-align:center; font-size: 95%; font-weight: bold;">What do you want to track for a Week? </p>

<form action ="Backend/goals.php" method="post">
<input type="text" name="goal" id="goal" placeholder="Name your Goal or Habit">
    <p style="color:lightgray; font-size: 80%;">Track anything you want by entering its name above
      or choose from the options below
    </p>
<div>
  <input type="radio" id="exercising" name="habits" value="exercising">
  <label for="exercising">Exercising</label>
</div>
<div>
  <input type="radio" id="meditating" name="habits" value="meditating">
  <label for="meditating">Meditating</label>
</div>
<div>
  <input type="radio" id="no_alcohol" name="habits" value="no_alcohol">
  <label for="no_alcohol">No alcohol</label>
</div>
<div>
  <input type="radio" id="get_up_early" name="habits" value="get_up_early">
  <label for="get_up_early">Get up early</label>
</div>
<div>
  <input type="radio" id="sleep_on_time" name="habits" value="sleep_on_time">
  <label for="sleep_on_time">Sleep on time</label>
</div>
<div>
  <input type="radio" id="budget" name="habits" value="budget">
  <label for="budget">Budget</label>
</div>


<input type="submit" value="Set Goal">

</form>
</div>