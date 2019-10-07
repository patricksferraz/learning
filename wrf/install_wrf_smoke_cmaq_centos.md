# Guia para instalar WRF-CMAQ-SMOKE e WRF-CHEM no CentOS 6.6 com gcc-gfortran-g++

_OBS: ao criar variáveis de ambiente no /etc/profile NUNCA dar um source /etc/profile (ex: igual se faz com o bashrc) pois quando reiniciar o computador vai dar BUG no seu sistema._

_OBS: É alguns casos é melhor setar as variáveis de ambiente no_ **~/.bashrc** _ao invés do_ **/etc/profile**

_OBS: SEMPRE que atualizar alguma variável de ambiente no_ **/etc/profile**, _reinicie o sistema, assim as mudanças vão estar valendo._

_OBS: o comando_ **./configure** _por padrão instala no diretório_ **/usr/local**, _mas no tutorial eu vou acrescentar, quando for o caso, o_ **./configure --prefix=/usr/local**

- **SITES INTERESSANTES**

[Site](http://www2.mmm.ucar.edu/wrf/OnLineTutorial/compilation_tutorial.php#STEP1) NCAR para compilar o WRF.

[SITE](http://www.ncl.ucar.edu/Download/build_from_src.shtml) NCL/UCAR para instalar o NCL/NCARG.

**Sempre usar primeiro o comando**

```sh
yum update
```

**depois o comando**

```sh
yum install epel*
```

**Depois o comando abaixo para instalar essas bibliotecas**

```sh
yum install -y *glibc*{i386,i686,x86_64} glib*{i386,i686,x86_64} *libcurl*{i386,i686,x86_64} libstdc++*{i386,i686,x86_64} *libgcc*{i386,i686,x86_64} *libgfortran*{i386,i686,x86_64} ImageMagick* libibverbs*{i386,i686,x86_64} libibumad*{i386,i686,x86_64} libuuid*{i386,i686,x86_64} infinipath-psm*{i386,i686,x86_64} tcl* procps*{i386,i686,x86_64} papi*{i386,i686,x86_64} libtool-ltdl*{i386,i686,x86_64} python{i386,i686,x86_64} libnl*{i386,i686,x86_64} opensm-libs*{i386,i686,x86_64} lm_sensors-libs*{i386,i686,x86_64} environment-modules*{i386,i686,x86_64} openssh-clients*{i386,i686,x86_64}  libX11*{i386,i686,x86_64} librdmacm*{i386,i686,x86_64} jasper-libs*{i386,i686,x86_64} libjpeg*{i386,i686,x86_64} gcc*{i386,i686,x86_64} g++*{i386,i686,x86_64} cpp*{i386,i686,x86_64} flex* csh*{i386,i686,x86_64} libncurses5*{i386,i686,x86_64} bison*{i386,i686,x86_64} curl* m4*{i386,i686,x86_64} make*{i386,i686,x86_64} expat*{i386,i686,x86_64} libX11*{i386,i686,x86_64} *X11*{i386,i686,x86_64} ntfs-3g*{i386,i686,x86_64} *automake*{i386,i686,x86_64} *autoconf*{i386,i686,x86_64} *autoheader*{i386,i686,x86_64} *aclocal*{i386,i686,x86_64} *libtoolize*{i386,i686,x86_64} *pkg-config*{i386,i686,x86_64} *gtk-doc*{i386,i686,x86_64} xorg-x11*{i386,i686,x86_64} libffi*{i386,i686,x86_64} --skip-broken
```

calma... teste primeiro se o perl já esta instalado com o comando **perl -v** ... se sim não é preciso usar o comando abaixo

```sh
yum install perl{i386,i686,x86_64}
```

Por padrão o **CentOS 6.6** vem com o **gcc 4.4.7**, e para compilar o WRF 3.5.1 para frente é necessário versões mais atuais, para isso vamos instalar o **devtools-2** para instalar os pacotes mais atuais do **gcc (4.8.2)**.

Para instalar o devtools 2 no CentOS é preciso primeiro importar a _[GPG-RPM-Key-cern](http://mirror.internode.on.net/pub/scientific/510/x86_64/RPM-GPG-KEYs/RPM-GPG-KEY-cern)_ do SLC6

KEY --> salvar com o nome **"RPM-GPG-KEY-cern"** sem extensão (**não** colocar .txt ou .dat)

```
-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: GnuPG v1.2.6 (GNU/Linux)

mQGiBEK/0MURBACv5Rm/jRnrbyocW5t43hrjFxlw/DPLTWiA16apk3P2HQQ8F6cs
EY/gmNmUf4U8KB6ncxdye/ostSBFJmVYh0YEYUxBSYM6ZFui3teVRxxXqN921jU2
GbbWGqqlxbDqvBxDEG95pA9oSiFYalVfjxVv0hrcrAHQDW5DL2b8l48kGwCgnxs1
iO7Z/5KRalKSJqKx70TVIUkD/2YkkHjcwp4Nt1pPlKxLaFp41cnCEGMEZVsNIQuJ
1SgHyMHKBzMWkD7QHqAeW3Sa9CDAJKoVPHZK99puF8etyUpC/HfmOIF6jwGpfG5A
S7YbqHX6vitRlQt1b1aq5K83J8Y0+8WmjZmCQY6+y2KHOPP+zHWKe5TJDeqDnN0j
sZsKA/441IF4JJTPEhvRFsPJO5WKg1zGFbxRPKvgi7+YY6pJ0VFbOMcJVMkvSZ2w
4QRD+2ets/pRxNhITHfPToMV3lhC8m1Je5fzoSvSixgH/5o9mekWWSW7Uq7U0IWA
7OD7RraJRrGxy0Tz3G+exA7svv/zn9TW/BaHFlMHoyyDHOYZmIhhBB8RAgAhBQJC
v+/uFwyAEeb+6rc8Txi4s8pfgZAf4xOTel99AgcAAAoJEF4D/eUdHgNLGCgAmwdu
KegSOBXpDe061zF8NoN6+OFiAJ9nKo+uC6xBZ9Ey550SmhFCPPA2/rRTQ0VSTiBM
aW51eCBTdXBwb3J0IChSUE0gc2lnbmluZyBrZXkgZm9yIENFUk4gTGludXggU3Vw
cG9ydCkgPGxpbnV4LnN1cHBvcnRAY2Vybi5jaD6IWgQTEQIAGgUCQr/QxQULBwMC
AQMVAgMDFgIBAh4BAheAAAoJEF4D/eUdHgNL/HsAn1ntKwRoSA9L0r8UyF7Zqn3U
79m1AJ9Y4NsSE/dlFYLfmf0+baoq7b5asIicBBMBAgAGBQJCv9DjAAoJEPy9YCiW
u335GTwEALjUQ7+cHxi0sifstCLoyRYQSu7Eas0M1UD2ZxSQNBnYsx4rDZJk9TmK
7QCzR1yRw9aixzZsRlNbed5VPxSzn89PE5m7Sx1bpl89sPgZ4BY95AL2wExyDWRp
1ON2+ztYeYtT7ZCkmeM+PBzt6RHR/jo3361faBS+qOkmpiiRWf3XiEYEExECAAYF
AkK/0WAACgkQkB/jE5N6X33DFQCgkvy1ruogu5Ibs5CzGY/ALiSJhyAAn3ygn3p/
xrNQ8Dy5j4KfgJINoxT4iEYEEBECAAYFAkK/9CcACgkQDIloXtlLxZSiRACdG0kT
KlB4X4VBocUyxMReO9e5MvsAoIKWgcJYE8AGmRXjfIisCAzPtVX+iEYEExECAAYF
AkK/8oUACgkQtQgG0wyY/52z1ACgkkxNdhHKbEol3Kwka1tICWHMIwIAn3PWJQR0
C1MV1+CnT8UupHzxy6J7
=IUD3
-----END PGP PUBLIC KEY BLOCK-----
```

- **Importar a KEY**

```sh
rpm --import /pasta/onde/esta/a/RPM-GPG-KEY-cern
```

Depois fazer os seguintes comandos para instalar

```sh
cd /etc/yum.repos.d/
wget -O /etc/yum.repos.d/slc6-devtoolset.repo <http://linuxsoft.cern.ch/cern/devtoolset/slc6-devtoolset.repo>
yum install -y devtoolset-2
```

Esse comando habilita o devtools-2 APENAS no Terminal, não no sistema.

```sh
scl enable devtoolset-2 bash
```

Adicionar o **/etc/profile** o seguinte comando

Comando para habilitar o **devtools-2** com **gcc-gfortran-g++** para todos os usuarios

```sh
source /opt/rh/devtoolset-2/enable
```

Para verificar se o gcc foi atualizado use o comando

```sh
gcc -v
```

Até aqui instalamos as bibliotecas, complementos e atualizamos o gcc para 4.8.2, agos vamos iniciar a instalar as bibliotecas necessárias para compilar os modelos. Uma ótima referência é o "How to build NCL and NCAR Graphics from source code" [site](http://www.ncl.ucar.edu/Download/build_from_src.shtml). Esse site vai ajudar e muito na instalação das bibliotecas. Muitas delas já estão instaladas, use o comando

```sh
locate nome.da.lib
```

para encontrar o que você precisa. Caso ocorra erros de bad interpreter ou syntax durante as próximas etapas, faça:

```sh
vi script_que_falhou
# no script_que_falhou:
# :set fileformat=unix
# :x!
```

- **Instalar biblioteca JPEG-6b**

```sh
./configure --prefix=/usr/local --disable-shared make all make check make all install
```

Se der a mensagem de erro **"cannot create regular file `/usr/local/man/man1/cjpeg.1': No such file or directory"**. É só ir no diretório **usr/local** e criar o diretorio "man" e depois dentro do "man1" e em seguida rodar os comandos acima

Se foi instalado a versão 6b é preciso fazer ainda

```sh
make install-lib
make install-headers
```

- **Instalar a biblioteca zlib (1.2.8)**

```sh
./configure --prefix=/usr/local --disable-shared
make all
make check
make all install
```

- **Instalar a biblioteca PNG (libpng-1.2.52)**

```sh
export LDFLAGS='-L/usr/local/lib'
export CPPFLAGS='-I/usr/local/include'
./configure --with-pic --prefix=/usr/local --disable-shared
make all
make check
make all install
```

- **Instalar a biblioteca FreeType (2.5.5)**

```sh
./configure --prefix=/usr/local --disable-shared
make all
make check
make all install
```

Se aparecer o seguinte erro

**"rmdir: failed to remove "/usr/local/include/freetype2/freetype/config': No such file or directory"**

Vá dentro do diretório **"/usr/local/include/freetype2"** crie uma pasta chamada **"freetype"** e copie o a pasta **"config"** que está no diretório atual para a pasta recem criada (freetype) e refaça os comandos para instalar

- **Instalar a biblioteca Jasper (1.900.1)**

```sh
./configure --prefix=/usr/local --disable-shared
make all
make check
make all install
```

_OBS: Uma forma alternatica é criar uma pasta em_ **"/opt/jasper-1.900.1"** _e instalar o jasper lá. Isso porque as vezes é preciso setar o caminho no profile para a compilação do WRF_

Instalar a biblioteca **openmpi-1.6.5** (Tive problemas com o **openmpi 1.8.4**, por isso fui para a versão 1.6)

Criar um diretório em **/opt**

```sh
mkdir /opt/openmpi-1.6.5
export FC=gfortran
export F77=gfortran
export CC=gcc
export CXX=g++
./configure --prefix=/opt/openmpi-1.6.5 --enable-static --disable-shared
make
make check
make install
```

Adicionar no final do **/etc/profile** os caminhos para o openmpi

```sh
gedit /etc/profile &
export MPI_HOME=/opt/openmpi-1.6.5
export PATH=$PATH:/opt/openmpi-1.6.5/bin
```

- **Instalar a biblioteca NETCDF (4.1.3 ou 4.1.2)**

A partir da versão 4.2, a unidata dividiu o netcdf-C do netcdf-fortran. Se você instalar uma versão mais atual é preciso instalar o netcdf-C primeiro, setar as variaveis de ambiente e assim instalar o netcdf-fortran. A versão 4.1.3 tem as duas em um arquivo só.

Criar um diretório em **/opt/netcdf-4.1.2**

```sh
mkdir /opt/netcdf-4.1.2
export CC=gcc
export CXX=g++
export CPPFLAGS='-DNDEBUG -DgFortran'
export CFLAGS='-O'
export F77=gfortran
export FC=gfortran
export F90=gfortran
export FFLAGS='-O -w -m64'
export FCFLAGS='-m64'
./configure --prefix=/opt/netcdf-4.1.2 --disable-netcdf-4 --disable-shared --disable-dap
make all
make check
make all install
```

Adicionar no final do **/etc/profile** os caminhos para o netcdf

```sh
gedit /etc/profile &
export PATH=$PATH:/opt/netcdf-4.1.2/bin export NETCDF=/opt/netcdf-4.1.2
```

- **Instalar a biblioteca HDF5-1.8.12**

```sh
mkdir /opt/hdf5-1.8.12
export CC=gcc
export CXX=g++
export F77=gfortran
export FC=gfortran
export F90=gfortran
export CPPFLAGS='-I/usr/local/include'
export LDFLAGS='-L/usr/lib:/usr/lib64'
./configure --prefix=/opt/hdf5-1.8.12 --with-zlib=/usr/local --enable-static --disable-shared --enable-fortran
make all
make check
make all install
```

Adicionar no final do **/etc/profile** os caminhos para o netcdf

```sh
gedit /etc/profile &
export PATH=$PATH:/opt/hdf5-1.8.12/bin
export HDF5_DIR=/opt/hdf5-1.8.12
```

Instalar as bibliotecas do _ncl/ncarg_ - baixar o binário que mais se aproxima do seu sistema no [site](https://www.earthsystemgrid.org/home.htm).

Criar um diretório dentro de **/opt/ncl-versao.do.ncl.ncarg**

Depois copiar **tar.gz** para dentro do diretório criado e descompactar e seguir os passo do [site](http://www.ncl.ucar.edu/Download/install.shtml). Depois exportar as variaveis de ambiente:

```sh
export NCARG_ROOT=/opt/ncl-6.1.2
export PATH=$NCARG_ROOT/bin:$PATH
```

Para testar o NCL, digite o comando abaixo - se estiver correto vai aparecer um grafico em branco e quando for clicando nele as imagens vão mudando até sumir o gráfico

```sh
ng4ex gsun01n -clean
```

Para testar o NCARG, digite o códico abaixo vai aparecer varias mensagens no terminal, se tudo correr certo, vai aparecer o _"Compiling e linking..."_ e não vai aparecer nenhuma mensagem de "error ou warning".

```sh
ncargex cpex08 -clean
```

Agora é só colocar as variáveis no **etc/profile**

## Instalar WRF 3.6.1

Como as variaveis de ambiente estão setadas para NETCDF, basta setar as seguintes variaveis

```sh
export WRFIO_NCD_LARGE_FILE_SUPPORT=1
```

Adicionar as variaveis do jasper no **/etc/profile**

```sh
export JASPERLIB=/usr/local/lib
export JASPERINC=/usr/local/include
./configure
```

No configure escolher as melhores opções para seu sistema operacional - neste caso escolhi a opção **"34"** x86_64 compilador **gcc-gfortran dmpar** depois a opção **1** (default) para "nested"

Quando o configure terminou, abrir o **"configure.wrf"** no gedit e verificar se as variaveis abaixo estão corretas

```
SFC = gfortran
    SCC = gcc
    CCOMP = gcc
    DM_FC = mpif90
    DM_CC = mpicc -DMPI2_SUPPORT
```

Após acertar o configure é só compilar

```sh
./compile em_real |& tee compile_em_real.log
```

Quando a compilação terminar verificar se os executáveis foram criados na pasta **"main"**

```sh
ls main/*.exe
```

Terminado tudo, adicionar as linhas abaixo no arquivo **/etc/security/limits.conf**

```
soft    stack   100000000
hard    stack   100000000
```

_Agora o WRF está pronto para ser executado._

## Instalar WPS 3.6.1

Para compilar o WPS, certifique-se que os caminhos para o jasper estão setados, se sim...

```sh
./configure
```

Geralmente o WPS é executado em serial com suporto para Grib2\. Selecione essa opção com o compilador usado neste caso foi usado a opção **"1"** serial gfortran. Depois é só compilar

```sh
./compile |& tee compile_wps.log
```

## Dados Estáticos para o WPS

É possível obter o arquivo compactado no caminho [wps_files](http://www2.mmm.ucar.edu/wrf/src/wps_files/)

```sh
wget http://www2.mmm.ucar.edu/wrf/src/wps_files/geog_complete.tar.gz
tar -xvf geog_complete.tar.gz
```

Um passo opcional seria renomear o arquivo para ser mais intuitivo

```sh
mv geog WPS_GEOG
```

Assim é preciso setar no namelist.wps (diretório onde está instalado o WPS) o diretório onde está localizado o GEOG. Abra o arquivo e busque por **geog_data_path** deixando da seguinte forma:

```
geog_data_path=path_para_o_diretorio/WPS_GEOG
```
