$(document).ready(function () {
  getAndDisplayContacts();

  $("#btnOpenModal").click(function () {
    $("#myModal").css("display", "block");
    $("#overlay").css("display", "block");
  });

  $("#btnCloseModal").click(function () {
    $("#myModal").css("display", "none");
    $("#overlay").css("display", "none");
  });

  $("#overlay").click(function () {
    $("#myModal").css("display", "none");
    $("#overlay").css("display", "none");
  });

  function hideEditContactModal() {
    $("#editContactModal").css("display", "none");
  }

  $("#btnCloseModal").click(function () {
    hideEditContactModal();
  });

  $("#formAjoutContact").submit(function (event) {
    event.preventDefault();
    var nom = $("#nom").val();
    var prenom = $("#prenom").val();
    var numero = $("#numero").val();
    var email = $("#email").val();
    addContact(nom, prenom, numero, email);
    $("#myModal").css("display", "none");
    $("#overlay").css("display", "none");
  });

  $("#searchForm").submit(function (event) {
    event.preventDefault();
    var nom = $("#name").val();
    var prenom = $("#surname").val();
  });

  function addContact(nom, prenom, numero, email) {
    $.ajax({
      url: "ajax.php",
      type: "POST",
      dataType: "json",
      data: {
        action: "addContact",
        nom: nom,
        prenom: prenom,
        numero: numero,
        email: email,
      },
      success: function (response) {
        if (response.success) {
          console.log("Contact ajouté avec succès!");
          getAndDisplayContacts();
        } else {
          console.error("Erreur lors de l'ajout du contact.");
        }
      },
      error: function (error) {
        console.error(error);
      },
    });
  }

  function deleteContact(contactId) {
    $.ajax({
      url: "ajax.php",
      type: "POST",
      dataType: "json",
      data: { action: "deleteContact", contactId: contactId },
      success: function (response) {
        if (response.success) {
          getAndDisplayContacts();
          console.log("Contact supprimé avec succès!");
        } else {
          console.error("Erreur lors de la suppression du contact.");
        }
      },
      error: function (xhr, status, error) {
        console.error(error);
      },
    });
  }

  function getAndDisplayContacts() {
    $.ajax({
      url: "./ajax.php",
      type: "POST",
      dataType: "json",
      data: { action: "getData" },
      success: function (response) {
        if (response.success) {
          displayContacts(response.success);
        } else {
          handleAjaxError(response.error);
        }
      },
      error: function (error) {
        console.error(error);
      },
    });
  }

  function displayContacts(contacts, filter) {
    var contactListElement = $("#contactList");
    contactListElement.empty();

    contacts.forEach(function (contact) {
      var idInput = $(
        '<input type="hidden" id="editContactId" name="ContactId" >'
      );
      idInput.val(contact.id);

      $("#btnEditContact").before(idInput);

      var contactCard = $(
        '<div id="contactCard_' +
          contact.id +
          '" class="card contact-card"></div>'
      );
      contactCard.attr("data-contact-id", contact.id);

      contactCard.append("<p>Nom: " + contact.nom + "</p>");
      contactCard.append("<p>Prénom: " + contact.prenom + "</p>");
      contactCard.append("<p>Numéro: " + contact.numero_telephone + "</p>");
      contactCard.append("<p>Email: " + contact.email + "</p>");

      $(".contacts-container").append(contactCard);

      var deleteButton = $('<button class="delete-button">Supprimer</button>');
      deleteButton.click(function () {
        confirmDeleteContact(contact.id);
      });
      contactCard.append(deleteButton);

      function showEditContactModal(contact) {
        $("#editContactModal").css("display", "block");
      }

      var editButton = $('<button class="edit-button">Modifier</button>');
      editButton.click(function () {
        showEditContactModal(contact);
      });

      contactCard.append(deleteButton);
      contactCard.append(editButton);

      contactListElement.append(contactCard);
    });

    function confirmDeleteContact(contactId) {
      var confirmation = confirm(
        "Êtes-vous sûr de vouloir supprimer ce contact ?"
      );
      if (confirmation) {
        deleteContact(contactId);
      }
    }
  }
});

function showEditContactModal(contact) {
  $("#editNom").val(contact.nom);
  $("#editPrenom").val(contact.prenom);
  $("#editNumero").val(contact.numero_telephone);
  $("#editEmail").val(contact.email);

  $("#editContactId").val(contact.id);

  $("#editContactModal").css("display", "block");
}

function modifierContact() {
  var editNom = $("#editNom").val();
  var editPrenom = $("#editPrenom").val();
  var editNumero = $("#editNumero").val();
  var editEmail = $("#editEmail").val();
  var editContactId = $("#editContactId").val();

  $.ajax({
    type: "POST",
    url: "ajax.php",
    data: {
      action: "EditContact",
      editNom: editNom,
      editPrenom: editPrenom,
      editNumero: editNumero,
      editEmail: editEmail,
      editContactId: editContactId,
    },
    success: function (response) {
      console.log(response);
      $("#editContactModal").css("display", "none");
    },
    error: function (error) {
      console.error("Erreur AJAX :", error);
    },
  });
}

$(document).on("submit", "#formEditContact", function (event) {
  event.preventDefault();
  modifierContact();
});

$(document).on("click", ".edit-button", function () {
  var contactCard = $(this).closest(".contact-card");
  var contact = {
    id: contactCard.find("#editContactId").val(),
    nom: contactCard.find("p:contains('Nom:')").text().replace("Nom: ", ""),
    prenom: contactCard
      .find("p:contains('Prénom:')")
      .text()
      .replace("Prénom: ", ""),
    numero_telephone: contactCard
      .find("p:contains('Numéro:')")
      .text()
      .replace("Numéro: ", ""),
    email: contactCard
      .find("p:contains('Email:')")
      .text()
      .replace("Email: ", ""),
  };

  showEditContactModal(contact);
});
