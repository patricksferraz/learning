# from graphene import String, Int, Float, Boolean, ID
import graphene as gp


nome = gp.String(
    name="naoEhNome",
    description="Nome do ...",
    required=True,
    deprecation_reason="Inutilizado devido ...",
    default_value="Anonymous",
)
idade = gp.Int()
peso = gp.Float()
vivo = gp.Boolean()
nascimento = gp.Date()
hora_nascimento = gp.Time()
cadastro = gp.DateTime()
dados = gp.JSONString()

other = gp.Field(gp.String)
