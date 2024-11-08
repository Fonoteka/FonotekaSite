import { createClient } from 'jsr:@supabase/supabase-js@2'

const supabase = createClient('https://zaxdehkvsnwabvoyyesz.supabase.co', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InpheGRlaGt2c253YWJ2b3l5ZXN6Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzA0NjMyNjAsImV4cCI6MjA0NjAzOTI2MH0.RBCCjHhdeN9AboULGfFOTngF5nq_tbImynDnb7NnakI')

    document.getElementById('form-guia').addEventListener('submit', async function (event) {
      event.preventDefault();
  
      const fileInput = document.getElementById('imagem');
      const file = fileInput.files[0];
  
      if (!file) {
        msgPop('Por favor, selecione um arquivo.');
        return;
      }
  
      const fileName = `${Date.now()}-${file.name}`;
  
      try {
        const { data, error } = await supabase.storage
          .from('images')
          .upload(fileName, file);
  
        if (error) {
          throw msgPop(`ERRO: ${error}`);
        }
  
      } catch (error) {
        console.error('Erro ao fazer upload', error);
      }
    });
