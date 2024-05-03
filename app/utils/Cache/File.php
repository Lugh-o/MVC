<?php 

namespace app\Utils\Cache;

class File {

    /**
     * Método responsável por retornar o conteudo gravado no cache
     * @param string $hash
     * @param integer $expiration
     * @return mixed     
     */
    private static function getContentCache($hash, $expiration){
        $cacheFile = self::getFilePath($hash);
        
        //verifica a existencia do arquivo
        if(!file_exists($cacheFile)) return false;

        //valida a expiração do cache
        $createTime = filectime($cacheFile);
        $diffTime = time() - $createTime;
        if($diffTime > $expiration) return false;

        $serialize = file_get_contents($cacheFile);

        //retorna o dado real
        return unserialize($serialize);
    }

    /**
     * Método responsável por retornar o caminho até o arquivo de cache
     * @param string $path
     * @return string
     */
    private static function getFilePath($hash){
        $dir = getenv("CACHE_DIR");
        
        //verifica a existencia do diretorio
        if(!file_exists($dir)){
            mkdir($dir, 0755, true);
        }

        //retorna o caminho até o arquivo
        return $dir."/".$hash;
    }

    /**
     * Metodo responsavel por guardar informações no cache
     * @param string $hash
     * @param mixed $content
     * @return boolean
     */
    private static function storageCache($hash, $content){
        //serializa o retorno
        $serialize = serialize($content);
        
        //obtem o caminho até o arquivo de cache
        $cacheFile = self::getFilePath($hash);
        
        //grava as informaçoes no arquivo
        return file_put_contents($cacheFile, $serialize);
    }

    /**
     * Método responsável por obter uma informação do cache 
     * @param string $hash
     * @param integer $expiration
     * @param Closure $fuunction
     * @return mixed
     */
    public static function getCache($hash, $expiration, $function){
        //verifica o conteudo gravado
        if($content = self::getContentCache($hash, $expiration)){
            return $content;
        }
        
        $content = $function();

        //grava o retorno no cache
        self::storageCache($hash, $content);

        //retorna o conteudo
        return $content;
    }
}