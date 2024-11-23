document.addEventListener("DOMContentLoaded", async function () {
  if (typeof supabase !== "undefined") {
    const supabaseClient = supabase.createClient(
      "https://zaxdehkvsnwabvoyyesz.supabase.co",
      "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InpheGRlaGt2c253YWJ2b3l5ZXN6Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzA0NjMyNjAsImV4cCI6MjA0NjAzOTI2MH0.RBCCjHhdeN9AboULGfFOTngF5nq_tbImynDnb7NnakI"
    );

    const select_alunos = document.querySelector(".alunos_list");
    const idMentor = localStorage.getItem("idMentor");

    var aviso = document.querySelector("#aviso-select");
    var p = document.querySelector("#aviso-select-p");

    const alunos_lista = await procuraAlunos();
    selectAlunos(alunos_lista);

    var dataAtividades;

    select_alunos.addEventListener("change", async () => {
      loading(true);
      apagaAtividade(false);
      if (select_alunos.value) {
        try {
          const { data, error } = await supabaseClient
            .from("tb_atividades")
            .select("idatividade,nomeatividade, path_imagem")
            .eq("idaluno", select_alunos.value);

          dataAtividades = data;
          itemAtividade(dataAtividades);
        } catch (error) {
          msgPop(`ERRO: ${error}`);
          return;
        }
      } else {
        aviso.style.display = "block";
        p.innerHTML = "Por favor, selecione um aluno";
      }
      loading(false);

      const lista_btnExcluir = document.querySelectorAll(".excluir");
      lista_btnExcluir.forEach((botao) => {
        botao.addEventListener("click", async () => {
          loading(true);
          try {
            const data = await supabaseClient
              .from("tb_atividades")
              .delete()
              .eq("idatividade", botao.id);
          } catch (error) {
            msgPop(`ERRO: ${error}`);
            return;
          }
          await apagaAtividade(botao.id);
          loading(false);
        });
      });
    });

    async function procuraAlunos() {
      try {
        const { data, error } = await supabaseClient
          .from("tb_cadastroaluno")
          .select("idaluno, nome")
          .eq("idmentor", idMentor);
        return data;
      } catch (error) {
        msgPop(`ERRO: ${error}`);
        return;
      }
    }

    function selectAlunos(alunos_lista) {
      alunos_lista.forEach((aluno) => {
        const option = document.createElement("option");
        const textNome = document.createTextNode(aluno.nome.toUpperCase());
        option.value = aluno.idaluno;
        option.appendChild(textNome);
        select_alunos.appendChild(option);
      });
    }

    function itemAtividade(atividades) {
      const ul = document.querySelector(".atividade-lista");
      if (atividades.length > 0) {
        aviso.style.display = "none";
        atividades.forEach((item) => {
          const li = document.createElement("li");
          li.classList.add("atividade-item");
          li.id = item.idatividade;

          const img = document.createElement("img");
          img.classList.add("atividade-img");
          img.src = item.path_imagem;
          img.alt = item.nomeatividade;
          img.id = `img${item.idatividade}`;

          const h2 = document.createElement("h2");
          h2.classList.add("item-titulo");
          h2.innerHTML = item.nomeatividade;

          const div = document.createElement("div");
          div.classList.add("item-action");

          const btnAlterar = document.createElement("input");
          btnAlterar.value = "Alterar";
          btnAlterar.classList.add("action-button");
          btnAlterar.type = "button";

          const btnExcluir = document.createElement("input");
          btnExcluir.value = "Excluir";
          btnExcluir.classList.add("action-button", "excluir");
          btnExcluir.type = "button";
          btnExcluir.id = item.idatividade;

          div.appendChild(btnAlterar);
          div.appendChild(btnExcluir);

          li.appendChild(img);
          li.appendChild(h2);
          li.appendChild(div);
          ul.appendChild(li);
        });
      } else {
        aviso.style.display = "block";
        p.innerHTML = "Esse aluno não possui nenhuma atividade atribuida";
      }
    }

    async function apagaAtividade(idLi) {
      const lista_atividade_item = document.querySelectorAll(".atividade-item");

      if (idLi === false) {
        lista_atividade_item.forEach((atividade) => {
          atividade.remove();
        });
        return;
      }

      // const img = document.querySelector("#img" + idLi);

      // try {
      //   const { data, error } = await supabaseClient.storage
      //     .from("imagesAtividade")
      //     .remove(["1732317287583-imagem_2024-11-22_185508202.png"]);

      //   if (error) {
      //     msgPop(error);
      //   }
      // } catch (error) {
      //   msgPop(`ERRO: ${error}`);
      //   return;
      // }

      const liCard = document.getElementById(idLi);
      liCard.remove();
    }
  }
});
