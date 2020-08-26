<div class="m-3">
  <h2 class="text-center js-playerName"></h2>
  <form class="d-flex justify-content-center js-playerForm">
    <div>
      <input type="text" name="name" class="form-control" placeholder="Enter your name" maxlength="20" required>
    </div>
    <button type="submit" class="btn btn-primary ml-3">Connect</button>
  </form>
</div>

<div class="game-grid">
  <div class="game-grid__overlay js-gameOverlay"></div>
  <div>
    <?php for ($row = 0; $row < 9; $row++) : ?>
      <div class="game-grid__row">
        <?php for ($col = 0; $col < 9; $col++) : ?>
          <div class="game-grid__cell">
            <?php if (!empty($sudoku[$row][$col])) : ?>
              <input type="text" class="game-grid__input game-grid__input--fill js-gameInput" maxlength="1" data-row="<?= $row ?>" data-col="<?= $col ?>" value="<?= $sudoku[$row][$col] ?>" disabled>
            <?php else : ?>
              <input type="text" class="game-grid__input js-gameInput" maxlength="1" data-row="<?= $row ?>" data-col="<?= $col ?>">
            <?php endif; ?>
          </div>
        <?php endfor; ?>
      </div>
    <?php endfor; ?>
  </div>
</div>

<div class="modal fade text-danger" id="modal-error" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <h2 class="modal-title" id="exampleModalLabel">Error!</h2>
        <div class="lead pt-4 js-errorMessage"></div>
      </div>
      <div class="modal-footer mt-4">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade text-danger" id="modal-failedGame" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center">
        <h2 class="modal-title" id="exampleModalLabel">The game is lost</h2>
        <div class="lead pt-4">You can try to win again!</div>
      </div>
      <div class="modal-footer justify-content-between mt-4">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">New game</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade text-success" id="modal-successGame" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center">
        <h2 class="modal-title" id="exampleModalLabel">The game is won!</h2>
        <div class="lead pt-4">
          Winner: <b class="js-gameWinner">Almor</b>
        </div>
      </div>
      <div class="modal-footer justify-content-between mt-4">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">New game</button>
      </div>
    </div>
  </div>
</div>