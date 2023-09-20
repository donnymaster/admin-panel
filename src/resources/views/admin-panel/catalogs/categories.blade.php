@extends('admin-panel.layouts.main')

@section('title', 'Категории')

@section('content')
    <div class="drop-down-list-container">

    </div>

    <script>

        class TreeList {
            constructor() {
                this.containerElement = document.querySelector('.drop-down-list-container');

                this.loadData();
                this.render();
            }

            loadData() {
                // fetch

                this.categories = [{
                        id: 1,
                        name: 'Мягкие игрушки',
                        parent_id: 0,
                        slug: 'igruhski-myagkie'
                    },
                    {
                        id: 2,
                        name: 'Игрушки',
                        parent_id: 0,
                        slug: 'igruhski'
                    }
                ];
            }

            render() {
                this.categories.forEach(category => {
                    this.createCategory(category);
                });
            }

            createCategory(category) {
                const categoryElement = document.createElement("div");
                categoryElement.textContent = category.name;

                this.containerElement.append(categoryElement);
            }
        }

        new TreeList();
    </script>
@endsection

@section('sidebar')
    <x-admin.sidebar.categories />
@endsection
