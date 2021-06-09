<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\EventoModel;


class Eventos extends BaseController
{

    use ResponseTrait;



    public function index()
    {
        $model = new EventoModel();
        $data = [
            'title' => 'I Fórum de Tecnologias na Área Farmacêutica',
            'data' => $model->findAll(),
        ];

        echo view('templates/header', $data);
        echo view('tdeventos');
        echo view('templates/footer');
    }


    //------------------------------------------------------------------------------


    // lista todos eventos
    public function listar()
    {
        $model = new EventoModel();
        $data = [
            'title' => 'I Fórum de Tecnologias na Área Farmacêutica',
            'data' => $model->findAll(),
        ];

        echo view('templates/header', $data);
        echo view('listeventos');
        echo view('templates/footer');
    }


    //------------------------------------------------------------------------------


    // lista um eventos
    // public function show($id = null)
    // {
    //     $model = new EventoModel();
    //     $data = $model->getWhere(['id' => $id])->getResult();

    //     if($data){
    //         return $this->respond($data);
    //     }

    //     return $this->failNotFound('Nenhum evento encontrado com id '.$id);        
    // }


    //------------------------------------------------------------------------------


    // adiciona um eventos
    public function cadeventos()
    {

        helper(['form', 'url']);

        $model = new EventoModel();
        $data = [
            'title' => 'Cadastre-se',
            // 'data' => $model->findAll(),
        ];

        if ($this->request->getMethod() == 'post') {

            //VALIDAÇÕES
            $rules = [
                'titulo' => 'trim|required|min_length[3]|max_length[60]',
                'imagem' => 'uploaded[profile_image]', 'mime_in[profile_image,image/jpg,image/jpeg,image/gif,image/png]', 'max_size[profile_image,4096]',
                'resumo' => 'trim|required|min_length[100]|max_length[200]',
            ];
            // echo './public/img';exit;
            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {

                //salva no BD
                $model =  new EventoModel();
                $uploadImagem = $this->upload_image($this->request->getFile('profile_image'));
                if ($uploadImagem) {                    
                    $newData = [
                        'titulo' => $this->request->getVar('titulo'),
                        'imagem' => $uploadImagem,
                        'resumo' => $this->request->getVar('resumo'),
                    ];

                    if ($model->save($newData)) {
                        $session = session();
                        $session->setFlashdata('success', 'Seu evento foi cadastrado com sucesso!');
                        return redirect()->to(base_url());
                    } else {
                        echo "Erro ao salvar";
                        exit;
                    }
                } else {
                    echo "Erro no upload";
                    exit;
                }
            }
        }

        echo view('templates/header', $data);
        echo view('cadevento');
        echo view('templates/footer');
    }


    public function upload_image($imagem)
    {
        $imageFile = $imagem;
        $nome = md5(uniqid()) . '_' . time() . '.jpg';
        if ($imageFile->move(WRITEPATH . '../public/img',$nome)) {
            return $nome;
        } else {
            return false;
        }
    }
 

    //------------------------------------------------------------------------------


    // atualiza um eventos

    public function editeventos()
    {
        $data = [
            'title' => 'Editar Evento',
        ];
        echo view('templates/header', $data);
        echo view('editeventos', $data);
        echo view('templates/footer');
    }


    // public function update($id = null)
    // {
    //     $model = new EventoModel();
    //     $data = $this->request->getJSON();

    //     if($model->update($id, $data)){
    //         $response = [
    //             'status'   => 200,
    //             'error'    => null,
    //             'messages' => [
    //                 'success' => 'Eventos atualizados'
    //                 ]
    //             ];
    //             return $this->respond($response);
    //         };

    //         return $this->fail($model->errors());
    //     }


    //------------------------------------------------------------------------------


    // deleta um eventos

    public function excluirevent()
    {
        $data = [
            'title' => 'Excluir evento',
        ];
        echo view('templates/header', $data);
        echo view('excluirevent', $data);
        echo view('templates/footer');
    }

    // public function delete($id = null)
    // {
    //     $model = new EventoModel();
    //     $data = $model->find($id);

    //     if($data){
    //         $model->delete($id);
    //         $response = [
    //             'status'   => 200,
    //             'error'    => null,
    //             'messages' => [
    //                 'success' => 'Eventos removidos'
    //             ]
    //         ];
    //         return $this->respondDeleted($response);
    //     }

    //     return $this->failNotFound('Nenhum evento encontrado com id '.$id);        
    // }
}
