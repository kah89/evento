<?php

namespace App\Models;

use CodeIgniter\Model;

class EventoModel extends Model
{
    protected $table = 'eventos';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'titulo', 'created_at', 'imagem', 'resumo', 'dtInicio', 'dtFim', 'userCreated', 'assinatura', 'tipo', 'estado', 'destinado', 'limite', 'corPrimaria', 'corSecundaria'];


    /**
     * Recebe como parâmetro o idUser e o idEvento e os insere no banco, registrando que a atividade X foi concluída pelo usuário Y na data e hora atual
     */
    public function inscricaoEvento($idUser = null, $idEvento = null)
    {
        $limite = $this
            ->select('limite')
            ->where('id', $idEvento)->get(1)->getRowArray();

        $data = [
            'idUser' => $idUser,
            'idEvento'  => $idEvento,
        ];

        $count = $this
            ->db->table('usuario_evento')
            ->select('count(usuario_evento.idEvento) as count')
            ->where('idEvento', $idEvento)->get(1)->getRowArray();


        $limite = (int)$limite['limite'];
        $count = (int)$count['count'];

        $array = array('idUser' => $idUser, 'idEvento' => $idEvento);
        $q = $this->db->table('usuario_evento')->select('idUser, idEvento')->where($array);

        if ($q->countAllResults() < 1) {
            if ($count < $limite) {
                if ($this->verificaInscricao($data)) {
                    if ($this
                        ->db
                        ->table('usuario_evento')
                        ->insert($data)
                    ) {
                        $result = "Inscrição efetuada com sucesso!";
                    } else {
                        $result = "Erro ao efetuar inscrição";
                    }
                } else {
                    $result = "Não é possivel inscrever nesse evento pois
                     conflita com outro evento ou este evento não é destinado para seu usuario.";
                }
            } else {
                $result = "Limite de inscrições para este evento atingido!";
            }
        } else {
            $result = "Inscrição já foi efetuada!";
        }
        return $result;
    }


    //---------------------------------------------------------------------------------------------

    public function certificado($idUser = null, $idEvento = null, $firstnameUser = null, $lastnameUser = null)
    {

        $data = [
            'idUser' => $idUser,
            'idEvento'  => $idEvento,
            'firstname' => $firstnameUser,
            'lastname' => $lastnameUser,
        ];

        $array = array('idUser' => $idUser, 'idEvento' => $idEvento);
        $q = $this->db->table('certificado')->select('*')->where($array);
        if ($q->countAllResults() < 1) {
            if ($this
                ->db
                ->table('certificado')
                ->insert($data)
            ) {
                $result = "Certificado gerado com sucesso!";
            }
        } else {
            $result = $this->db->table('certificado')->select('*')->where($array)->get()->getResultArray();
        }
        return $result;
    }


    //---------------------------------------------------------------------------------------------

    // Verifica se a inscrição é valida de acordo com os criterios do evento
    public function verificaInscricao($data = null)
    {
        $q = $this->select('*')->where('id=' . $data['idEvento'])->get(1)->getRowArray();

        //Verifica se a data de um evento que é exclusivo conflita com a data de outros eventos.
        if ($q['tipo'] == 2) {
            if ($a = $this->inscritoEventoExclusivo($data['idUser'])) {
                foreach ($a as $eventosInscritos) {
                    if (!($q['dtInicio'] < $eventosInscritos['dtInicio'] && $q['dtFim'] < $eventosInscritos['dtInicio']) || ($q['dtInicio'] > $eventosInscritos['dtInicio'] && $eventosInscritos['dtFim'] < $q['dtInicio'])) {
                        return false;
                    }
                }
            }
        } else {
            if ($a = $this->inscritoTodosEvento($data['idUser'])) {
                foreach ($a as $eventosInscritos) {
                    if (
                        !(($q['dtInicio'] < $eventosInscritos['dtInicio'] && $q['dtFim'] < $eventosInscritos['dtInicio'])
                            ||
                            ($q['dtInicio'] > $eventosInscritos['dtInicio'] && $eventosInscritos['dtFim'] < $q['dtInicio']))
                    ) {
                        return false;
                    }
                }
            }
        }



        // Verifica se o evento é destinado para determinado usuario 
        /*
        Tipos de evento : 1 evento para estudantes
                          2 evento somente para farmaceuticos
                          3 evento somente para farmaceuticos de SP
        */
        if (in_array("2", json_decode($q['destinado'])) && in_array("1", json_decode($q['destinado']))) {
            if (session()->get('type') == 1 || session()->get('type') == 2 || session()->get('type') == 0) {
                return true;
            } else {
                return false;
            }
        }
        if (in_array("2", json_decode($q['destinado']))) {
            if (session()->get('type') == 2 || session()->get('type') == 0) {
                return true;
            }
        }

        if (in_array("3", json_decode($q['destinado']))) {
            if (session()->get('type') == 2 && session()->get('estado') == '26' || session()->get('type') == 0) {
                return true;
            }
        }
        if (in_array("1", json_decode($q['destinado']))) {
            if (session()->get('type') == 1 || session()->get('type') == 0) {
                return true;
            }
        }
    }

    //---------------------------------------------------------------------------------------------
    public function quantidadeVagas($idEvento = null)
    {
        $limite = $this
            ->select('limite')
            ->where('id', $idEvento)->get(1)->getRowArray();

        $count = $this
            ->db->table('usuario_evento')
            ->select('count(usuario_evento.idEvento) as count')
            ->where('idEvento', $idEvento)->get(1)->getRowArray();
        $limite = (int)$limite['limite'];
        $count = (int)$count['count'];
        $result =   $limite - $count;
        return $result;
    }

    public function inscritoEventoExclusivo($idUser = null)
    {

        $result = $this
            ->select('*')
            ->join('usuario_evento', 'eventos.id = usuario_evento.idEvento')
            ->where('eventos.tipo', 1)
            ->where('usuario_evento.idUser', $idUser)->get()->getResultArray();
        return $result;
    }

    public function inscritoTodosEvento($idUser = null)
    {
        $result = $this
            ->select('*')
            ->join('usuario_evento', 'eventos.id = usuario_evento.idEvento')
            ->where('usuario_evento.idUser', $idUser)->get()->getResultArray();
        return $result;
    }
}
