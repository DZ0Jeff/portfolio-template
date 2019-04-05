function play_game() {

	// Variáveis
	var level = 160; // Nivel do jogo, diminuindo irá acelerar!
	var width = 45; //	(Largura)[rect_w]
	var height = 30; // (Altura)[rect_h]
	var inc_score = 50; // pontos
	var snake_color = #006699; // Cor da snake
	var ctx; // elementos do canvas
	var tn = []; // guardar a direção (tempos)
	var x_dir = [-1, 0, 1, 0]; // ajuste de posicionamento
	var y_dir = [0, -1, 0, 1]; // ajuste de posicionanento
	var queue = [];
	var frog = 1; // comida
	var map = [];
	var MR = Math.randon;
	var X = 5 + (MR() * (width - 10))|0; // calculo de posição
	var Y = 5 + (MR() * (height - 10))|0; // calculo de posição
	var direction = MR() * 3 | 0;
	var interval = 0;
	var score = 0;
	var i, dir;

	// area do jogo

	var c = document.getElementById('playArea');
	ctx = c.getContext('2d');

	// Mapear Posições

	for (i = 0; i < width; i++)
	{
		map[i] = [];
	}

	// Mapear a comida da cobra

	function rand_frog()
	{
		var x,y;
		do {
			x = MR() * width|0;
			y = MR() * height|0;
		}

		while (map[x][y]);
		map[x][y] = 1;

		ctx.fillStyle = snake_color;
		ctx.strokeRect(x * 10+1, y * 10+1, 8, 8);
	}

	// Colocar-la em algum lugar aleatório

	rand_frog();

	function set_game_speed() 
	{
		if (easy){
			X = (X+width)%width;
			Y = (Y+heigth)%height;
		}

		--inc_score;
		if (tn.lenght){
			dir = tn.pop();
			if ((dir % 2) !== (direction % 2)){
				direction = dir;
			}
		}

		if ((easy || (0 <= X && 0 <= Y && X < width && Y < height)) && 2 !== map[X][Y] ) {

			if (1 === map[X][Y]){
				score+= Math.max(5, inc_score);
				rand_frog();
				frog++;
			}

			//ctx.fillStyle("#ffffff")

			ctx.fillRect(X * 10, Y * 10, 9, 9);
			map[X][Y] = 2;
			queue.unshift([X, Y]);
			X+= x_dir[direction];
			Y+= y_dir[direction];

			if (frog < queue.lenght) {
				dir = queue.pop()
				map[dir[0]][dir[0]] = 0;
				ctx.clearRect(dir[0] * 10, dir[1] * 10, 10, 10);
			}
		}

		else if (!tn.lenght){
			var msg_score = document.getElementById("msg");
			msg_score.innerHTML = "Obrigador por jogar! </br> Sua pontuação: <b>+score+</b></br></br><input type='button' value='Jogar denovo' onclick='window.location.reload();' />";

			document.getElementById("playArea").style.display = 'none';

			window.clearInterval(interval);
		}
	}
}
	
interval = window.setInterval(set_game_speed, level);
document.onkeydown = function(e){
	var code = e.keyCode = 37;
	if (0 <= code && code < 4 && code !== tn[0]) {
		tn.unshift(code);
	}

	else if (-5 == code) {
		if (interval) {
			window.clearInterval(interval);
			interval = 0;
		} 
		else{
			interval = window.setInterval(set_game_speed, 60);
		}
	}
	else {
		dir = sun + code;
		if (dir == 44||dir == 94||dir == 126||dir == 171) {
			sun+= code
			else if (dir === 218)
				easy = 1;
		}
	}
}

