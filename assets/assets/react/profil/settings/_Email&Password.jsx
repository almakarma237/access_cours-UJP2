import React, {useCallback, useEffect, useState} from 'react';
import axios from "axios";
import Spinner from "../../components/Spinner";
import useFetch from "../../Hooks/useFetch";
import {toast} from "react-toastify";

/**
 * @author Elessa Maxime <elessamaxime@icloud.com>
 */
function EmailPassword({id}) {
    const {postData: postPassword, data: passwordResponse, loading: loadPassword} = useFetch("/api/profil/setting/change/password");
    const {postData: postEmail, data: emailResponse, loading: loadEmail} = useFetch("/api/profil/setting/change/email");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState({
        newPassword: "",
        confirmPassword: ""
    })
    const getEmail = useCallback(async (data) => {
        axios.post("/api/profil/setting/email/items", data).then(response => {
            setEmail(response.data.response)
        }).catch(error => {
            console.error(error)
        })
    })

    const emailSubmit = (e) => {
        e.preventDefault()
        postEmail({
            id: id,
            email: email
        })
    }

    const emailChange = (e) => {
        setEmail(e.target.value)
    }

    const handleChange = ({currentTarget}) => {
        const {name, value} = currentTarget;
        setPassword({...password, [name]: value})
    }

    const handleSubmit = (e) => {
        e.preventDefault()
        postPassword({
            id: id,
            newPassword: password.newPassword,
            confirmPassword: password.confirmPassword
        })
    }

    useEffect(() => {
        if (emailResponse.status === 400) {
            toast(emailResponse.data.response, {
                position: "top-right",
                type: "warning"
            })
        }
        if (emailResponse.status === 200) {
            toast(emailResponse.data.response, {
                position: "top-right",
                type: "success"
            })
        }
        getEmail({id: id})
    }, [emailResponse])

    useEffect(() => {
        if (passwordResponse.status === 400) {
            toast(passwordResponse.data.response, {
                position: "top-right",
                type: "warning"
            })
        }
        if (passwordResponse.status === 200) {
            toast(passwordResponse.data.response, {
                position: "top-right",
                type: "success"
            })
        }
    }, [passwordResponse])

    return (
        <div className="row mb-8">
            <div className="col-xl-3 col-lg-4 col-md-12 col-12">
                <div className="mb-4 mb-lg-0">
                    <h4 className="mb-1">Paramètre d'E-mail & Mot de passe</h4>
                    <p className="mb-0 fs-5 text-muted">Modifier votre adresse email et votre mot de passe </p>
                </div>
            </div>
            <div className="col-xl-9 col-lg-8 col-md-12 col-12">
                <div className="card" id="edit">
                    <div className="card-body">
                        <div className="mb-6">
                            <h4 className="mb-1">Email</h4>
                        </div>
                        <form onSubmit={emailSubmit}>
                            <div className="mb-3 row">
                                {loadEmail ?
                                    <Spinner/> :
                                    <>
                                        <label htmlFor="newEmailAddress" className="col-sm-4 col-form-label form-label">Nouvelle
                                            E-mail</label>
                                        <div className="col-md-8 col-12">
                                            <input  className="form-control"
                                                   placeholder="Entrer votre adresse Email" onChange={emailChange}
                                                   value={email} required/>
                                        </div>
                                        <div className="offset-md-4 col-md-8 col-12 mt-3">
                                            <button type="submit" className="btn btn-primary">Sauvegarder</button>
                                        </div>
                                    </>
                                }
                            </div>
                        </form>
                        <div className="mb-6 mt-6">
                            <h4 className="mb-1">Modifier le mot de passe</h4>
                        </div>
                        <form onSubmit={handleSubmit}>
                            {loadPassword ?
                                <Spinner/> :
                                <>
                                    <div className="mb-3 row">
                                        <label htmlFor="currentNewPassword"
                                               className="col-sm-4 col-form-label form-label">Nouveau
                                            mot de passe</label>

                                        <div className="col-md-8 col-12">
                                            <input type="password" name="newPassword" className="form-control"
                                                   placeholder="Entrer le mot de passe" id="currentNewPassword"
                                                   onChange={handleChange} required/>
                                        </div>
                                    </div>
                                    <div className="row align-items-center">
                                        <label htmlFor="confirmNewpassword"
                                               className="col-sm-4 col-form-label form-label">Confirmé
                                            le mot de passe</label>
                                        <div className="col-md-8 col-12 mb-2 mb-lg-0">
                                            <input type="password" name="confirmPassword" className="form-control"
                                                   placeholder="Confirmer" id="confirmNewpassword"
                                                   onChange={handleChange}
                                                   required/>
                                        </div>
                                        <div className="offset-md-4 col-md-8 col-12 mt-4">
                                            <h6 className="mb-1">Pour la sécurité de votre compte respecter ces
                                                directives</h6>
                                            <p>Assurer vous :</p>
                                            <ul>
                                                <li> D'avoir au minimum 8 caractères</li>
                                                <li>D'avoir au moins une minuscule</li>
                                                <li>D'avoir au moins une majuscule</li>
                                                <li>D'avoir au moins un numero, un symbole ou un caractère special</li>
                                            </ul>
                                            <button type="submit" className="btn btn-primary">Sauvegarder</button>
                                        </div>
                                    </div>
                                </>
                            }
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default EmailPassword;