<?php 
  $snake = 'http://localhost/portfolio/pages/snakeAlpha/index.php';
  $index = 'http://localhost/portfolio/index.html';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="mais.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Engine</title>
    <link rel="stylesheet" type="text/css" href="estilo.css">
    <script src="Sprite.js"></script>
  </head>
  <body>
    
    <script type="text/javascript">

      // Variáveis do jogo

      var canvas, ctx, ALTURA, LARGURA, maxPulos = 3, velocidade = 6, estadoAtual, record, img,

      // Fases

      pontosParaNovaFase = [5, 10, 15, 20],
      faseAtual = 0

      // labels

      labelNovaFase = {
        texto: "",
        opacidade: 0.0,

        fadeIn: function(dt) {
          var fadeInId = setInterval(function() {
            if (labelNovaFase.opacidade < 1.0)
              labelNovaFase.opacidade += 0.01;

            else {
              clearInterval(fadeInId);
            }
          }, 10 * dt);
        },

        fadeOut: function(dt) {
          var fadeOutId = setInterval(function() {
            if (labelNovaFase.opacidade > 0.0)
              labelNovaFase.opacidade -= 0.01;

            else {
              clearInterval(fadeOutId);
            }
          }, 10 * dt);
        }
      },

      // Telas

      estados = {
          jogar: 0,
          jogando: 1,
          perdeu: 2
      },

      // Chão

      chao = {
        y: 550,
        x: 0,
        altura: 50,
        
        atualiza: function() {

          this.x -= velocidade;

          if(this.x <= -30)
            this.x += 30;
        },

        desenha: function() {
          spriteChao.desenha(this.x, this.y);
          spriteChao.desenha(this.x + spriteChao.largura, this.y);
        }
      },

      // Personagem
      bloco = {
        x: 50,
        y: 0,
        altura: spriteBoneco.altura,
        largura: spriteBoneco.largura,
        gravidade: 1.6,
        velocidade: 0,
        forcaDoPulo: 23.6,
        qntPulos: 0,
        score: 0,
        rotacao: 0,
        vidas: 3,
        colidindo: false,

        atualiza: function() {
          this.velocidade += this.gravidade;
          this.y += this.velocidade;
          this.rotacao += Math.PI / 180 * velocidade;

          if (this.y > chao.y - this.altura && estadoAtual != estados.perdeu) 
                {
              this.y = chao.y - this.altura;
              this.qntPulos = 0;
              this.velocidade = 0;
          }
        },

        pula: function() {
          if (this.qntPulos < maxPulos) {
              this.velocidade = -this.forcaDoPulo;
              this.qntPulos++;
            }
        },

        reset: function() {
            this.velocidade = 0;
            this.y = 0;

            if (this.score > record){
               localStorage.setItem("record", this.score);
               record = this.score;
            }

            this.vidas = 3;
            this.score = 0;

            velocidade = 6;
            faseAtual = 0;
            this.gravidade = 1.6;
        },

        desenha: function() {
          //ctx.fillStyle = this.cor;
          //ctx.fillRect(this.x, this.y, this.largura, this.altura);
          ctx.save();
          ctx.translate(this.x + this.largura/2, this.y + this.altura/2);
          ctx.rotate(this.rotacao);
          spriteBoneco.desenha(-this.largura / 2, -this.altura / 2);
          ctx.restore();
          
        }
      },

      //Obstaculos

      obstaculos = {
        _obs: [],
        _scored: false,
        cores: ["#ffbc1c", "#ff1c1c", "#ff85e1", "#52a7ff", "#78ff5d"],
        tempo: 0,

        insere: function() {
            this._obs.push({
              x: LARGURA,
              //largura: 30 + Math.floor(21 * Math.random()), Largura Aleatória.
              largura: 50,
              altura: 30 + Math.floor(120 * Math.random()),
              cor: this.cores[Math.floor(5 * Math.random())]
            });

            this.tempo = 30 + Math.floor(21 * Math.random());
        },

        atualiza: function() {
          if (this.tempo == 0)
              this.insere();
          else
              this.tempo--;

          for (var i = 0, tam = this._obs.length; i < tam; i++) {
            var obs = this._obs[i];

            obs.x -= velocidade;

            if (!bloco.colidindo &&bloco.x <= obs.x + obs.largura && bloco.x + bloco.largura >= obs.x && bloco.y + bloco.altura >= chao.y - obs.altura) {
              bloco.colidindo = true;

             bloco.colidindo = true

            setTimeout(function() {
              bloco.colidindo = false;
            }, 500);

            if (bloco.vidas >= 1)
              bloco.vidas--;

            else {
              estadoAtual = estados.perdeu
              }
            }

            else if (obs.x <= 0 && !obs._scored){
              bloco.score++;
              obs._scored = true;

              if (faseAtual < pontosParaNovaFase.length && bloco.score == pontosParaNovaFase[faseAtual]) 
                passarDeFase();
            }

            else if (obs.x <= -obs.largura) {
              this._obs.splice(i, 1);
              tam--;
              i--;
            }
          }
        },

        limpa: function() {
          this._obs = [];
        },

        desenha: function() {
          tam = this._obs.length;

            for (var i=0; i<tam; i++){
              var obs = this._obs[i];
              ctx.fillStyle = obs.cor;
              ctx.fillRect(obs.x, chao.y- obs.altura, obs.largura, obs.altura);
          }
        },
      };

      function clique(event) {
        if (estadoAtual == estados.jogando)
          bloco.pula();

        else if (estadoAtual == estados.jogar) {
          estadoAtual = estados.jogando;
        }

        else if (estadoAtual == estados.perdeu && bloco.y >= 2 * LARGURA) {
          estadoAtual = estados.jogar;
          obstaculos.limpa();
          bloco.reset();
        }
      }

      function passarDeFase() {
        velocidade++;
        faseAtual++;
        bloco.vidas++;

        if (faseAtual == 4)
        bloco.gravidade *= 0.6;

        labelNovaFase.texto = "Level " + faseAtual;
        labelNovaFase.fadeIn(0.4);

        setTimeout(function() {
          labelNovaFase.fadeOut(0.4);
        }, 800);
      }

      function main() {
        ALTURA = window.innerHeight;
        LARGURA = window.innerWidth;

        if (LARGURA => 500) {
          LARGURA = 600;
          ALTURA = 600;
        }

        canvas = document.createElement("canvas");
        canvas.width = LARGURA;
        canvas.height = ALTURA;
        canvas.style.border = "1px solid #000";

        ctx = canvas.getContext("2d");
        document.body.appendChild(canvas);

        document.addEventListener("mousedown", clique);

        estadoAtual = estados.jogar;
        record = localStorage.getItem("record");

        if (record == null)
          record = 0;

        img = new Image();
        img.src = "img/sheet.png";

        roda();
      }

      function roda() {
        atualiza();
        desenha();

        window,requestAnimationFrame(roda);
      }

      function atualiza() {

        chao.atualiza();

        bloco.atualiza();

        if (estadoAtual == estados.jogando)
            obstaculos.atualiza();

      }

      function desenha() {
        //ctx.fillStyle = "#08daff";
        //ctx.fillRect(0, 0, ALTURA, LARGURA);
        bg.desenha(0, 0);
        

        ctx.fillStyle = "#fff";
        ctx.font = "50px arial";
        ctx.fillText(bloco.score, 30, 68);
        ctx.fillText(bloco.vidas, 540, 68);
        
        ctx.fillStyle = "rgba(0, 0, 0, " + labelNovaFase.opacidade + ")";
        ctx.fillText(labelNovaFase.texto, canvas.width / 2 - ctx.measureText(labelNovaFase.texto).width / 2, canvas.height / 3);

        if (estadoAtual == estados.jogando)
          obstaculos.desenha();

        chao.desenha();
        bloco.desenha();

        if (estadoAtual == estados.jogar) {
          jogar.desenha(LARGURA / 2 - jogar.largura / 2 , ALTURA / 2 - jogar.altura /2);
        }

        if (estadoAtual == estados.perdeu) {
          perdeu.desenha(LARGURA / 2 - perdeu.largura / 2 , ALTURA / 2 - perdeu.altura /2 - spriteRecord.altura / 2);
        

          spriteRecord.desenha(LARGURA / 2 - spriteRecord.largura / 2, ALTURA / 2 + perdeu.altura / 2 - spriteRecord.altura / 2 - 25);


          ctx.fillStyle = "#fff";
          ctx.fillText(bloco.score, 375, 390);

          if (bloco.score > record) {
            novo.desenha(LARGURA / 2 - 180, ALTURA / 2 + 30);
            ctx.fillText(bloco.score, 420, 470);
          } 
          else {
              ctx.fillText(record, 420, 470);
          }
        }

      }

      // Inicializa o jogo
      main();
    </script>
    
    <footer class="w3-display-container w3-black w3-padding">
      <nav class="w3-bar menu">
        <div class="w3-bar-item w3-hover-blue"><a href="<?php echo $index; ?>">Menu principal</a></div>
        <div class="w3-bar-item w3-hover-orange"><a href="<?php echo $snake; ?>">Snake</a></div>
      </nav>
      <div class="w3-display-middle">@DZjeff</div>
    </footer>
  </body>
</html>