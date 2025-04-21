import React, { useState, useEffect } from 'react';
import { Head } from '@inertiajs/react';
import axios from 'axios';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogFooter } from '@/components/ui/dialog';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useToast } from '@/components/ui/use-toast';
import { AppShell } from '@/components/app-shell';

interface Theme {
  id: number;
  name: string;
  created_at: string;
  updated_at: string;
}

export default function Index() {
  const [themes, setThemes] = useState<Theme[]>([]);
  const [loading, setLoading] = useState(true);
  const [isCreateDialogOpen, setIsCreateDialogOpen] = useState(false);
  const [isEditDialogOpen, setIsEditDialogOpen] = useState(false);
  const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
  const [currentTheme, setCurrentTheme] = useState<Theme | null>(null);
  const [name, setName] = useState('');
  const [errors, setErrors] = useState<{ name?: string[] }>({});
  const { toast } = useToast();

  useEffect(() => {
    fetchThemes();
  }, []);

  const fetchThemes = async () => {
    try {
      setLoading(true);
      const response = await axios.get('/api/admin/themes');
      setThemes(response.data.data);
      setLoading(false);
    } catch (error) {
      console.error('Erreur lors du chargement des thèmes:', error);
      setLoading(false);
      toast({
        title: 'Erreur',
        description: 'Impossible de charger les thèmes.',
        variant: 'destructive',
      });
    }
  };

  const openCreateDialog = () => {
    setName('');
    setErrors({});
    setIsCreateDialogOpen(true);
  };

  const openEditDialog = (theme: Theme) => {
    setCurrentTheme(theme);
    setName(theme.name);
    setErrors({});
    setIsEditDialogOpen(true);
  };

  const openDeleteDialog = (theme: Theme) => {
    setCurrentTheme(theme);
    setIsDeleteDialogOpen(true);
  };

  const handleCreate = async () => {
    try {
      const response = await axios.post('/api/admin/themes', { name });
      setThemes([...themes, response.data.data]);
      setIsCreateDialogOpen(false);
      toast({
        title: 'Succès',
        description: 'Thème créé avec succès.',
      });
    } catch (error: any) {
      if (error.response?.data?.errors) {
        setErrors(error.response.data.errors);
      } else {
        toast({
          title: 'Erreur',
          description: 'Une erreur est survenue lors de la création du thème.',
          variant: 'destructive',
        });
      }
    }
  };

  const handleUpdate = async () => {
    if (!currentTheme) return;

    try {
      const response = await axios.put(`/api/admin/themes/${currentTheme.id}`, { name });
      setThemes(themes.map(theme => theme.id === currentTheme.id ? response.data.data : theme));
      setIsEditDialogOpen(false);
      toast({
        title: 'Succès',
        description: 'Thème mis à jour avec succès.',
      });
    } catch (error: any) {
      if (error.response?.data?.errors) {
        setErrors(error.response.data.errors);
      } else {
        toast({
          title: 'Erreur',
          description: 'Une erreur est survenue lors de la mise à jour du thème.',
          variant: 'destructive',
        });
      }
    }
  };

  const handleDelete = async () => {
    if (!currentTheme) return;

    try {
      await axios.delete(`/api/admin/themes/${currentTheme.id}`);
      setThemes(themes.filter(theme => theme.id !== currentTheme.id));
      setIsDeleteDialogOpen(false);
      toast({
        title: 'Succès',
        description: 'Thème supprimé avec succès.',
      });
    } catch (error) {
      toast({
        title: 'Erreur',
        description: 'Une erreur est survenue lors de la suppression du thème.',
        variant: 'destructive',
      });
    }
  };

  return (
    <AppShell>
      <Head title="Gestion des thèmes" />
      
      <div className="container py-6">
        <div className="flex justify-between items-center mb-6">
          <h1 className="text-2xl font-bold">Gestion des thèmes</h1>
          <Button onClick={openCreateDialog}>Nouveau thème</Button>
        </div>

        <Card>
          <CardHeader>
            <CardTitle>Liste des thèmes</CardTitle>
          </CardHeader>
          <CardContent>
            {loading ? (
              <div className="text-center py-4">Chargement...</div>
            ) : (
              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead>ID</TableHead>
                    <TableHead>Nom</TableHead>
                    <TableHead>Date de création</TableHead>
                    <TableHead className="text-right">Actions</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  {themes.length === 0 ? (
                    <TableRow>
                      <TableCell colSpan={4} className="text-center">Aucun thème trouvé</TableCell>
                    </TableRow>
                  ) : (
                    themes.map((theme) => (
                      <TableRow key={theme.id}>
                        <TableCell>{theme.id}</TableCell>
                        <TableCell>{theme.name}</TableCell>
                        <TableCell>{new Date(theme.created_at).toLocaleDateString()}</TableCell>
                        <TableCell className="text-right">
                          <Button variant="outline" size="sm" className="mr-2" onClick={() => openEditDialog(theme)}>
                            Modifier
                          </Button>
                          <Button variant="destructive" size="sm" onClick={() => openDeleteDialog(theme)}>
                            Supprimer
                          </Button>
                        </TableCell>
                      </TableRow>
                    ))
                  )}
                </TableBody>
              </Table>
            )}
          </CardContent>
        </Card>
      </div>

      {/* Dialogue de création */}
      <Dialog open={isCreateDialogOpen} onOpenChange={setIsCreateDialogOpen}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Créer un nouveau thème</DialogTitle>
          </DialogHeader>
          <div className="space-y-4 py-4">
            <div className="space-y-2">
              <label htmlFor="name" className="text-sm font-medium">Nom du thème</label>
              <Input 
                id="name" 
                value={name} 
                onChange={(e) => setName(e.target.value)} 
                placeholder="Entrez le nom du thème"
              />
              {errors.name && <p className="text-sm text-red-500">{errors.name[0]}</p>}
            </div>
          </div>
          <DialogFooter>
            <Button variant="outline" onClick={() => setIsCreateDialogOpen(false)}>Annuler</Button>
            <Button onClick={handleCreate}>Créer</Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>

      {/* Dialogue de modification */}
      <Dialog open={isEditDialogOpen} onOpenChange={setIsEditDialogOpen}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Modifier le thème</DialogTitle>
          </DialogHeader>
          <div className="space-y-4 py-4">
            <div className="space-y-2">
              <label htmlFor="edit-name" className="text-sm font-medium">Nom du thème</label>
              <Input 
                id="edit-name" 
                value={name} 
                onChange={(e) => setName(e.target.value)} 
                placeholder="Entrez le nom du thème"
              />
              {errors.name && <p className="text-sm text-red-500">{errors.name[0]}</p>}
            </div>
          </div>
          <DialogFooter>
            <Button variant="outline" onClick={() => setIsEditDialogOpen(false)}>Annuler</Button>
            <Button onClick={handleUpdate}>Mettre à jour</Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>

      {/* Dialogue de suppression */}
      <Dialog open={isDeleteDialogOpen} onOpenChange={setIsDeleteDialogOpen}>
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Confirmer la suppression</DialogTitle>
          </DialogHeader>
          <div className="py-4">
            <p>Êtes-vous sûr de vouloir supprimer le thème "{currentTheme?.name}" ?</p>
            <p className="text-sm text-red-500 mt-2">Cette action est irréversible.</p>
          </div>
          <DialogFooter>
            <Button variant="outline" onClick={() => setIsDeleteDialogOpen(false)}>Annuler</Button>
            <Button variant="destructive" onClick={handleDelete}>Supprimer</Button>
          </DialogFooter>
        </DialogContent>
      </Dialog>
    </AppShell>
  );
} 