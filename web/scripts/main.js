let socket = new WebSocket('ws://localhost:8080');

socket.onmessage = (e) => {
  const response = JSON.parse(e.data);

  switch (response.action) {
    case 'change':
      let input = document.querySelector('.js-gameInput' + '[data-row="' + response.row + '"]' + '[data-col="' + response.col + '"]');

      input.value = response.value;
      input.classList.add('game-grid__input--fill');
      input.setAttribute('disabled', true);

      break;
    case 'setName':
      startGame(response.name);

      break;
    case 'successGame':
      const successModal = new bootstrap.Modal(document.getElementById('modal-successGame'));
      const winnerBlock = document.querySelector('.js-gameWinner');

      winnerBlock.innerHTML = response.winner;
      successModal.show();

      break;
    case 'failedGame':
      const failedModal = new bootstrap.Modal(document.getElementById('modal-failedGame'));

      failedModal.show();

      break;
    case 'topPlayers':
      const playersModal = new bootstrap.Modal(document.getElementById('modal-topPlayers'));
      const tableBody = document.querySelector('.js-topPlayersTable');

      let tableContent = '';
      const name = sessionStorage.getItem('name');

      if (response.players.length == 0) {
        response.players.push({
          name: name ? name : 'You',
          wins: 0
        });
      }

      for (let i = 0; i < response.players.length; i++) {
        const player = response.players[i];

        tableContent += `
          <tr class="` + (name == player.name ? 'table-active' : '') + `">
            <th>` + (i + 1) + `</th>
            <th>` + player.name + `</th>
            <td>` + player.wins + `</td>
          </tr>
        `;
      }

      tableBody.innerHTML = tableContent;
      playersModal.show();

      break;
    case 'error':
      const errorModal = new bootstrap.Modal(document.getElementById('modal-error'));
      const errorMessageBlock = document.querySelector('.js-errorMessage');

      errorMessageBlock.innerHTML = response.message;
      errorModal.show();

      break;
  }
};

socket.onopen = () => {
  const name = sessionStorage.getItem('name');

  if (name) {
    setName(name);
  }
};

let gameInputs = document.querySelectorAll('.js-gameInput');

gameInputs.forEach((input) => {
  input.addEventListener('input', (event) => {
    const target = event.target;
    const row = target.getAttribute('data-row');
    const col = target.getAttribute('data-col');
    const value = target.value;

    socket.send(JSON.stringify({
      action: 'change',
      row: row,
      col: col,
      value: value,
    }));
  });
});

const playerForm = document.querySelector('.js-playerForm');

playerForm.addEventListener('submit', (event) => {
  event.preventDefault();

  const formData = new FormData(playerForm);
  const name = formData.get('name').trim();

  setName(name);
});

const gameModals = document.querySelectorAll('#modal-successGame, #modal-failedGame');

gameModals.forEach((modal) => {
  modal.addEventListener('hidden.bs.modal', () => {
    window.location.reload();
  });
});

const topPlayersButton = document.querySelector('.js-showTopPlayers');

topPlayersButton.addEventListener('click', () => {
  socket.send(JSON.stringify({
    action: 'topPlayers'
  }));
});

function setName(name) {
  socket.send(JSON.stringify({
    action: 'setName',
    name: name
  }));
}

function startGame(name) {
  const playerNameBlock = document.querySelector('.js-playerName');
  const playerForm = document.querySelector('.js-playerForm');
  const gameOverlay = document.querySelector('.js-gameOverlay');

  playerForm.classList.remove('d-flex');
  playerForm.classList.add('d-none');
  gameOverlay.classList.add('d-none');

  playerNameBlock.innerHTML = name;
  sessionStorage.setItem('name', name);
}

