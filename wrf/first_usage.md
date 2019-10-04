# Usage WRF

## Anotação 1

**Docker image gerada com wrf e wps instalados:** [Docker wrf-centos](https://cloud.docker.com/u/patricksferraz/repository/docker/patricksferraz/wrf-centos)

**Instação do Docker (Debian e derivados)**

```sh
sudo apt-get install docker docker.io containerd
```

**Pull com Docker:**

```sh
docker pull patricksferraz/wrf-centos:latest
```

**Executar a imagem com wrf**

```sh
docker run -it patricksferraz/wrf-centos /bin/bash
```

_... ou com volume mapeado também no host_

```sh
docker run -it -v path_no_docker:path_no_host patricksferraz/wrf-centos /bin/bash
```

## Anotação 2

- **Geogrid** - Definir um domínio inicial para o modelo e quaisquer domínios aninhados
- **Ungrib** - Extrair campos meteorológicos do conjuntos de dados GRIB, para o período de simulação especificado
- **Metgrid** - Interpolar horizontalmente os campos meteorológicos para os domínios do modelo
- **real.exe** - Pós-processar os dados gerados pelos softwares anteriores
- **wrf.exe** - Pós-processar os dados criados pelo executável real.exe e, assim, gerar os dados resultantes da simulação, a serem visualizados posteriormente por outro software

## Anotação 3

### **Primeiros passos para executar o WRF na imagem Docker**

- *Obs: O docker foi inicializado da seguinte forma:

  ```sh
  docker run -it -v /home/ferraz/Downloads/processing:/root/processing patrickferraz/wrf-centos /bin/bash
  ```

- *Obs: Foi alterado as permissões da pasta para o host poder modificar (executar comando na imagem docker) `sh chmod 777 ~/processing`sh

- _Obs: Antes de prosseguir, verificar a Anotação 4_

**Criação de uma pasta qualquer para organizar os dados**

```sh
mkdir -p ~/processing/WRFData; cd ~/processing/WRFData
```

**Copiar os arquivos bases para execução dos programas**

```sh
cp /path_do_WPS/geogrid/GEOGRID.TBL.ARW ./GEOGRID.TBL
cp /path_do_WPS/metgrid/METGRID.TBL.ARW ./METGRID.TBL
cp /path_do_WPS/namelist.wps ./namelist.wps
```

_Obs: Na imagem Docker o WPS está instalado em /opt/WPS_

**Configurando o namelist.wps** Necessário alterar/adicionar três parâmetros:

- **geog_data_path** indica os dados a serem usados pelo geogrid (já informado na Anotação 4)
- **opt_geogrid_tbl_path = './'** indicando o caminho para o GEOGRID.TBL
- **opt_metgrid_tbl_path = './'** indicando o caminho para o METGRID.TBL

_Obs: [User Guide V3.6.1](http://www2.mmm.ucar.edu/wrf/users/docs/user_guide_V3.6.1/users_guide_chap3.htm) link para ótimas referências sobre WRF e variáveis do namelist. Para buscar outras referências basta acessar [User Guide All](http://www2.mmm.ucar.edu/wrf/users/docs/)._

**Configurando o Ungrid**

_Obs: Variáveis importantes para configurar o ungrib_:

- _No arquivo share: start_date; end_date; interval_seconds_
- _Em ungrib: out_format ('WPS', 'SI' ou 'MM5')_

[Download da base de dados](http://www2.mmm.ucar.edu/wrf/users/download/free_data.html) meteorológicos para simulação nas datas especificadas no namelist.

Realizar os passos:

- Nome do arquivo deve estar em conformidade com a data do namelist seguindo o padrão: "fnl_ANOMÊSDIA_HORAS_MINUTOS"
- Copiar a Variable_Table referente ao padrão do arquivo ungrid escolhido. Variables disponíveis em _path_para_WPS/ungrib/Variable_Tables_.
- Criar um link para o variable table, de forma que o ungrid possa acessálo (realizado no diretório corrente WRFData):

  - `sh ln -s /path_para_WPS/ungrib/Variable_Tables/Vtable.GFS Vtable`

- Cópia e execução do script link_grib.csh para vinculação dos arquivos GRIB baixados.

  - `sh cp /path_para_WPS/link_grib.csh .`
  - `sh ./link_grib.csh lista_dos_arquivos_grib`sh

**Preparação para o real e wrf**

Cópia dos arquivos para o diretório local (_WRFData_)

```sh
cp /path_do_WRFV3/run/*_DATA .
cp /path_do_WRFV3/run/*.TBL .
cp /path_do_WRFV3/run/namelist.input .
```

Necessário editar o arquivo _namelist.input_ para adequação dos parâmetros desejados, como p.ex: _run_days, run_hours, run_minutes, run_seconds e as datas de início e fim._

**Mensagens após execução de cada software**

- geogrid

  - Mensagem: _Successful completion of geogrid_.
  - resultados em WRFData ou caminho do _opt_output_from_geogrid_path_: prefixo **geo_** e extensão **.nc**
  - Arquivo de log: **geogrid.log**

- ungrib

  - Mensagem: _Successful completion of ungrib_.
  - resultado em WRFData: formato com prefixo **FILE** conforme definido no namelist **FILE:ANO-MÊS-DIA_HORA**
  - Arquivo de log: **ungrib.log**

- metgrid

  - Mensagem: _Successful completion of metgrid_.
  - resultados em WRFData ou caminho do _opt_output_from_metgrid_path_: prefixo **met_** e sufixo **ANO-MÊS-DIA_HORAS:MINUTOS:SEGUNDOS.nc**
  - Arquivo de log: **metgrid.log**

- real

  - Gera uma certa quantidade de arquivos dependendo do intervalo de tempo que foi definido inicialmente.
  - resultados em WRFData: prefixo **wrf**
  - gera: **namelist.output**, **wrfbdy_d01** (apenas para o domínio d01), **wrfinput_**, **wrffdda_d01** _(apenas para d01 desde que nudging esteja acontecendo apenas neste domínio)_
  - Arquivo de log: **rsl.error.** e **rsl.out.**

- wrf

  - resultados em WRFData: formato **wrfout_d0N_ANO-MÊS-DIA_HORAS:MINUTOS:SEGUNDOS**
  - log para verificar possíveis erros: arquivos **rsl.error.** e **rsl.out.** na seção **FATAL CALLED**

**Visualização de dados** Programar para exibir os resultados visualmente:

- NCAR Graphics
- Ncview

## Anotação 4

### **Devido ao grande volume de dados estáticos existentes para o WPS, o mesmo não foi adicionado na imagem, sendo necessário uma pré-configuração.**

**É possível obter o arquivo compactado no caminho <http://www2.mmm.ucar.edu/wrf/src/wps_files/>**

```sh
wget http://www2.mmm.ucar.edu/wrf/src/wps_files/geog_complete.tar.gz
tar -xvf geog_complete.tar.gz
```

**Um passo opcional seria renomear o arquivo para ser mais intuitivo**

```sh
mv geog WPS_GEOG*
```

_Obs: É preciso setar no namelist.wps (localizado no diretório onde está instalado o WPS) o diretório onde está localizado o GEOG._

**Abra o arquivo namelist.wps e busque por _geog_data_path_ deixando-o da seguinte forma** _geog_data_path = 'path_para_o_diretorio_WPS_GEOG'_

## Anotação 5

**Erros que podem ocorrer**

Falta de arquivos para execução do geogrid no caminho do GEOG: [Sources WPS GEOG](http://www2.mmm.ucar.edu/wrf/users/download/get_sources_wps_geog_V3.html)

## Anotação 6

**Referências:**

- [**online tutorial**](http://www2.mmm.ucar.edu/wrf/OnLineTutorial/index.php)
- [**uso wrf/wrf-chem**](https://wiki.harvard.edu/confluence/pages/viewpage.action?pageId=228526205)
- [**identificação do namelist.wps**](http://www2.mmm.ucar.edu/wrf/users/namelist_best_prac_wps.html#opt_output_from_metgrid_path)
- [**identificação do namelist.input**](http://www2.mmm.ucar.edu/wrf/users/namelist_best_prac_wrf.html)

**namelist.input**

- É possível obter os valores de __*_levels__ e __*_soil_levels__ através de:
  - `ncdump -h met_em.d0*.nc | more `
  - _num_metgrid_levels is typically in the header of the file_
  - _num_metgrid_soil_levels is close to the footer of the file_

