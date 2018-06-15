
<section class="user">
    <a href="{{route('admin.dashboard')}}"><img src="/images/logo_mbr_digital.svg" width="200" style="position:absolute;"></a>
    <!--<div class="profile-img">
<p><img src="https://mbr.digital/public/assets/admin/images/uiface2.png" alt="" height="40" width="40" /> Bem-vindo  Ludson Almeida </p>
</div>-->

    <div class="container">
        <div class="buttons">

            <form action="{{route('admin.leads.search')}}" method="post">
                {!!csrf_field()!!}
                <input type="search" id="aa-search-input" class="" placeholder="Pesquisar" name="search" autocomplete="on" spellcheck="false" ng-keyup="search()" ng-model="query" style="margin-right:-40px; max-width: 70%"/>
            </form>

        </div>

        <div class="buttons">
            <ul><!-- Atendente -->
                <a href="{{route('admin.lead.add')}}" title="MBR Follow Up - Adicionar Lead" alt="[Adicionar Lead]">
                    <li><img src="/images/leads/new_lead.svg" width="20" class="icone" title="MBR Follow Up - Adicionar Lead" alt="[Adicionar Lead]"></li>
                </a>
                @if(\Auth::user()->role == 3 OR \Auth::user()->role == 2)

                @else
                    <a href="{{route('admin.importar')}}" title="MBR Follow Up - Importar" alt="[Importar]">
                        <li><img src="/images/leads/upload.svg" width="20" class="icone" title="MBR Follow Up - Importar Planilha" alt="[Importar Planilha]"></li>
                    </a>
                @endif



                <a href="#" onclick="_urq.push(['Feedback_Open'])">

                    <li><img src="/images/leads/ajuda.svg" width="20" class="icone" title="MBR Follow Up - Help" alt="[Help]">
                    </li>
                </a>

                <a href="{{ route('admin.editar.usuario', Auth::user()->id) }}" style="color:#333" class="userperfil" title="Ver
             Perfil"><li>
                        <div class="foto">{!! Auth::user()->user_nome !!}</div>
                        <span>{!! Auth::user()->role_name !!}</span>
                        <img src="{{ Auth::user()->avatar }}" width="40" height="40" class="atendente perfilEdit">

                    </li></a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
                <a href="{{ route('admin.logout') }}" title="MBR Follow Up - Logout" alt="[Logout]" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><li><img src="/images/leads/logout.svg" width="20" class="icone"></li></a>

            </ul>
        </div>
</section>

<!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
<script src="{{asset('js/algoliasearch.min.js')}}"></script>
<script src="{{asset('js/autocomplete.min.js')}}"></script>
<script src="{{asset('js/angular.min.js')}}"></script>
<script src="{{asset('js/angular-sanitize.min.js')}}"></script>

<script>
    angular.module('AlgoliaApp', ['ngSanitize'])
        .factory('Contatos',function(){
            var client = algoliasearch("D4EIHRAU95", "44a22a5413aeb6e6c366eb92e132ce45");
            var index = client.initIndex('tb_contatos');

            return index;
        })
        .controller('Contatos',function($scope, Contatos){
            $scope.hits = [];
            $scope.query = '';
            $scope.initRun = true;
            $scope.search = function(){
                Contatos.search($scope.query, function(success, content){
                    $scope.hits = content.hits;
                });
            };
            $scope.search();
        });
</script>


