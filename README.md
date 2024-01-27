# Herramientas necesarias
- Visual Studio Code : https://code.visualstudio.com/
- Instalar la extensión PHP Server en VSCode
  
   ![image](https://github.com/dennisJcarrillo/Equipos-Cocinas/assets/117254003/5a9e5051-9112-490f-82de-a209caba10b2)

- SQL Server Managment Studio

# Dependencias de desarrollo
- Descargar PHP 8.3 (8.3.1) : https://windows.php.net/download/ (Instalar la versión que incluye Thread Safe. Y descargarla según su Sistema Operativo)

  ![image](https://github.com/dennisJcarrillo/Equipos-Cocinas/assets/117254003/40dd134a-5b37-465d-ba01-7bd321852255)

- Configurar la extensión PHP Server para que levante php.exe previamente instalado, siga el tutorial : https://code.visualstudio.com/docs/languages/php
- Sql Server 2022 : https://www.microsoft.com/es-es/sql-server/sql-server-downloads


# Dependencias en Producción
- Apache 2.4.58 : https://www.apachelounge.com/download/ (Elejir el ejectutable segun su Sistema Operativo, en este caso Windows, instalar Apache x64 = Win64  o x86 = Win32)
- Asegúrese de haber instalado la última versión 14.38.33130 de Visual C++ Redistributable Visual Studio 2015-2022 

![image](https://github.com/dennisJcarrillo/Equipos-Cocinas/assets/117254003/122807cc-20c9-44e7-a51f-7613841f69f3)

- PHP 8.3 (8.3.1) : https://windows.php.net/download/ (Instalar la versión que incluye Thread Safe. Y descargarla según su Sistema Operativo)
- Sql Server 2022 : https://www.microsoft.com/es-es/sql-server/sql-server-downloads

# Configuraciones necesarias tanto para el ambiente de Desarrrollo como para Produccción:
  
1. Descomprimir la carpeta PHP previamente descargada, en la siguiente ruta (disco local): **C:\**
2. Ahora, descargar y descomprimir el paquete de Drivers que provee Microsoft para conectar PHP & SQL Server: https://learn.microsoft.com/en-us/sql/connect/php/download-drivers-php-sql-server?view=sql-server-ver16 :  **SQLSRV511.ZIP** *(nombre de la carpeta que se descargará)*
3. Habiendo descomprimido la carpeta de Drivers, proceder a identificar los siguientes 2 archivos y copiarlos:

    ![image](https://github.com/dennisJcarrillo/Task-Performance/assets/117254003/371a256e-47e2-4de4-8219-8098a9b49c51)
**NOTA:** En la captura se seleccionan los driver *x64* ya que se espera que su sistema operativo sea de esta misma arquitectura, en caso contrario seleccionar los drivers *x86*
4. Dirigirse a la ruta según el ambiente: **Desarrollo -->** C:\php\ext **<-------------------------->** **Producción -->** C:\www\php\ext

   ![image](https://github.com/dennisJcarrillo/Task-Performance/assets/117254003/e23a8272-ecaa-4cd1-a121-06317582724c)
   
5. Habiendo copiado los drivers a la ruta indicada según el caso, volver a la ruta **C:\php**, buscar el archivo **php.ini-development** y renombrarlo a **php.ini**

   ![image](https://github.com/dennisJcarrillo/Task-Performance/assets/117254003/52b0e884-e402-45b1-8575-99340b4662c3)
6. Ahora, abrir el archivo **php.ini** con el bloc de notas o el Visual Studio Code
   - Abrir el buscador y escribir **exten**
   - Presionar ENTER hasta visualizar la sección que se indica en la imagen a continuación
   - Agregar las siguientes 2 lineas al final, en esta sección:
    ~~~
     extension=php_sqlsrv_82_ts_x64.dll
     extension=php_pdo_sqlsrv_82_ts_x64.dll
    ~~~
  ![image](https://github.com/dennisJcarrillo/Task-Performance/assets/117254003/00e8843e-e708-4cea-82b2-56aad703ee7b)
7. Todo deberia estar listo para poder leventar el proyecto, claro, siempre y cuando se tenga ya acceso a la base de datos con todas sus entidades. Para esto ponerse en contacto con los encargados del mismo.

##
