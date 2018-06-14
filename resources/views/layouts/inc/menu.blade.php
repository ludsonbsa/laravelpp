@if(Auth::user()->role == 1)
<nav>
    <ul>

        <li>
            <a href="{{route('admin.leads')}}" title="Leads" alt="[Leads]"><img src="/images/leads/leads_menu.svg" width="30" title="" alt="">Leads</a>

        </li>

        <li class="sub">
            <a href="{{route('admin.lead.add')}}" title="Add Lead" alt="[Add Lead]">Adicionar Lead</a>
        </li>

        <li>
            <a href="{{route('admin.comissoes.listar')}}" title="Comissões" alt="[Comissões]"><img src="/images/leads/comissoes_menu.svg" width="30" title="" alt="">Comissões</a>
        </li>


        <li>
            <a href="{{route('admin.listar.brindes')}}" title="Brindes" alt="[Brindes]"><img src="/images/leads/brinde_menu.svg" width="30" title="" alt="">Brindes</a>

        </li>


        <li class="sub">
            <a href="{{route('admin.brindes.add')}}" title="Add Brinde" alt="[Add Lead]">Adicionar Brinde</a>
        </li>


        <li class="sub">
            <a href="{{route('admin.brindes.buscar')}}" title="Buscar Brinde" alt="[Buscar Brinde]">Buscar Brinde</a>
        </li>

        <li>
            <a href="{{route('admin.listar.livro')}}" title="Livros" alt="[Livros]"><img src="/images/leads/brinde_menu.svg" width="30" title="" alt="">Brindes Livro</a>

        </li>

        <li class="sub">
            <a href="{{route('admin.livro.add')}}" title="Add Livro" alt="[Add Livro]">Adicionar Livro</a>
        </li>


        <li class="sub">
            <a href="{{route('admin.livro.buscar')}}" title="Buscar Livro" alt="[Buscar Livro]">Buscar Livro</a>
        </li>


        <li>
            <a href="{{route('admin.importar')}}" title="Importações" alt="[Importações]"><img src="/images/leads/importar_menu.svg" width="30" title="" alt="">Importações</a>

        </li>

        <li>
            <a href="{{route('admin.listar.usuarios')}}" title="Usuários" alt="[Usuários]"><img src="/images/leads/users_menu.svg" width="30" title="" alt="">Usuários</a>
        </li>

        <li>
            <a href="{{route('admin.config')}}" title="Configurações" alt="[Configurações]"><img src="/images/leads/config_menu.svg" width="30" title="" alt="">Configurações</a>
        </li>

    </ul>
</nav>
@endif <!-- Menu de Administrador -->

@if(Auth::user()->role == 2)
    <nav>
        <ul>

            <li>
                <a href="{{route('admin.leads')}}" title="Leads" alt="[Leads]"><img src="/images/leads/leads_menu.svg" width="30" title="" alt="">Leads</a>
            </li>

            <li class="sub">
                <a href="{{route('admin.lead.add')}}" title="Add Lead" alt="[Add Lead]">Adicionar Lead</a>
            </li>

        </ul>
    </nav>
@endif <!-- Menu de Responsável -->

@if(Auth::user()->role == 3)
<nav>
    <ul>

        <li>
        <a href="{{route('admin.leads')}}" title="Leads" alt="[Leads]"><img src="/images/leads/leads_menu.svg" width="30" title="" alt="">Leads</a>

    </li>

    <li class="sub">
        <a href="{{route('admin.lead.add')}}" title="Add Lead" alt="[Add Lead]">Adicionar Lead</a>
    </li>

        <li>
            <a href="{{route('admin.brindes.add')}}" title="Brindes" alt="[Brindes]"><img src="/images/leads/brinde_menu.svg" width="30" title="" alt="">Adicionar Brinde</a>

        </li>


        <li class="sub">
            <a href="{{route('admin.brindes.buscar')}}" title="Buscar Brinde" alt="[Buscar Brinde]">Buscar Brinde</a>
        </li>
        <li>
            <a href="{{route('admin.listar.livro')}}" title="Livros" alt="[Livros]"><img src="/images/leads/brinde_menu.svg" width="30" title="" alt="">Brindes Webnário</a>

        </li>

        <li class="sub">
            <a href="{{route('admin.livro.add')}}" title="Add Livro" alt="[Add Livro]">Adicionar Webkit</a>
        </li>


        <li class="sub">
            <a href="{{route('admin.livro.buscar')}}" title="Buscar Livro" alt="[Buscar Livro]">Buscar Webkit</a>
        </li>



    </ul>
</nav>
@endif <!-- Menu de Atendente -->

@if(Auth::user()->role == 4)
<nav>
    <ul>
    <li>
        <a href="{{route('admin.leads')}}" title="Leads" alt="[Leads]"><img src="/images/leads/leads_menu.svg" width="30" title="" alt="">Leads</a>

    </li>

    <li class="sub">
        <a href="{{route('admin.lead.add')}}" title="Add Lead" alt="[Add Lead]">Adicionar Lead</a>
    </li>

    <li>
        <a href="{{route('admin.listar.brindes')}}" title="Brindes" alt="[Brindes]"><img src="/images/leads/brinde_menu.svg" width="30" title="" alt="">Brindes</a>

    </li>

    <li class="sub">
        <a href="{{route('admin.brindes.add')}}" title="Add Brinde" alt="[Add Lead]">Adicionar Brinde</a>
    </li>


    <li class="sub">
        <a href="{{route('admin.brindes.buscar')}}" title="Buscar Brinde" alt="[Buscar Brinde]">Buscar Brinde</a>
    </li>

        <li>
            <a href="{{route('admin.listar.livro')}}" title="Livros" alt="[Livros]"><img src="/images/leads/brinde_menu.svg" width="30" title="" alt="">Brindes Livro</a>

        </li>

        <li class="sub">
            <a href="{{route('admin.livro.buscar')}}" title="Buscar Livro" alt="[Buscar Livro]">Buscar Livro</a>
        </li>



    </ul>
</nav>
@endif <!-- Menu do Suporte -->

@if(Auth::user()->role == 5)
<nav>
    <ul>
        <li>
            <a href="{{route('admin.leads')}}" title="Leads" alt="[Leads]"><img src="/images/leads/leads_menu.svg" width="30" title="" alt="">Leads</a>

        </li>

        <li class="sub">
            <a href="{{route('admin.lead.add')}}" title="Add Lead" alt="[Add Lead]">Adicionar Lead</a>
        </li>
    </ul>
</nav>
@endif <!-- Menu do Atendente Temporário -->