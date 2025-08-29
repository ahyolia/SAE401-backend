<?php 

    define("__DEBUG__", true); 
    
    function debug(string $variable):void { 
        global $$variable; 
        
        if(__DEBUG__) { 
            ob_start(); 
        // On arrête d'envoyer le flux dans la page générée 
?> 

        <div class="debug"> 
            <p><?= "Variable <span>$variable</span>" ?></p> 

<?php 
        var_dump($$variable); 
?> 

        </div> 
        
<?php 
        echo ob_get_clean(); 
        // On remet le flux en route en envoyant ce qui a été fait dans le contenu de la page
        }} 
        
?>