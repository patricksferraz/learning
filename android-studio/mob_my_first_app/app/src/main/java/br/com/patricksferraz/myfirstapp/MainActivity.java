package br.com.patricksferraz.myfirstapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;

public class MainActivity extends AppCompatActivity
{
    public static final String EXTRA_MESSAGE = "br.com.patricksferraz.myfirstapp.MESSAGE";

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
    }

    public void sendMessage (View view)
    {
        /**
         * Intent Fornece vinculos em tempo de execução entre componentes separados (como duas activities)
         * Usa doi parâmetros:
         *  - Context como primeiro (this é usado pq Activity é uma subclasse de Context)
         *  - Class do componente do aplicativo ao qual o sistema deve enviar o intent.
         *  - putExtra adiciona o valor editText à intent. Intent pode carregar tipos de dados como pares valor-chave chamado extra.
         *  chave EXTRA_MESSAGE pública constante defini chave extras de indents usando o nome do pacote do aplicativo como prefixo.
         *  - startActivity inicia uma instância da DisplayMessageActivity especificada pelo Indent
         */
        Intent intent = new Intent(this, DisplayMessageActivity.class);
        EditText editText = (EditText) findViewById(R.id.editText);
        String message = editText.getText().toString();
        intent.putExtra(EXTRA_MESSAGE, message);
        startActivity(intent);

    }
}
