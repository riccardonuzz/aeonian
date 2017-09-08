<?php

interface ILoginManager {

      /**
       * 
       * consente di effettuare il login
       *
       * @param array $post Contiene le informazioni dell'utente che vengono "postate"
       * @return int  0 se username e/o password sono errati, 1 se è un amministratore, 2 se è un cliente, 3 se è un installatore
       */
       function login($post);



        /**
       * 
       * consente di eseguire il logout distruggendo la sessione
       *
       * @return void
       */
    function logout();
}